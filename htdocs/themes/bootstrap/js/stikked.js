var ST = window.ST || {};

ST.init = function() {
    ST.show_embed();
};

ST.show_embed = function() {
    $embed_field = $('#embed_field');
    var lang_showcode = $embed_field.data('lang-showcode');
    $embed_field.hide();
    $embed_field.after('<a id="show_code" href="#">' + lang_showcode + '</a>');
    $('#show_code').on('click', function(e) {
        e.preventDefault();
        $(this).hide();
        $embed_field.show().select();
    });
    $embed_field.on("blur", function() {
        $(this).hide();
        $('#show_code').show();
    });
};

var CM = {
    init: function() {
        var txtAreas = $("textarea").length;

        if (txtAreas > 0) {
            modes = $.parseJSON($('#codemirror_modes').text());


            CM.editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                mode: "scheme",
                lineNumbers: true,
                matchBrackets: true,
                tabMode: "indent"
            });

            $('#lang').change(function() {
                set_language();
            });

            set_syntax = function(mode) {
                CM.editor.setOption('mode', mode);
            };

            set_language = function() {

                var lang = $('#lang').val();
                mode = modes[lang];

                $.get(base_url + 'main/get_cm_js/' + lang,
                    function(data) {
                        if (data !== '') {
                            set_syntax(mode);
                        } else {
                            set_syntax(null);
                        }
                    },
                    'script'
                );
            };

            set_language();
        }
    }
};

ST.line_highlighter = function() {
    var org_href = window.location.href.replace(/(.*?)#(.*)/, '$1');
    var first_line = false;
    var second_line = false;

    $('blockquote').on('mousedown', function(ev) {
        if (ev.which == 1) { // left mouse button has been clicked
            window.getSelection().removeAllRanges();
        }
    });

    $('blockquote').on('click', 'li', function(ev) {
        var $this = $(this);
        var li_num = ($this.index() + 1);
        if (ev.shiftKey == 1) {
            second_line = li_num;
        } else {
            first_line = li_num;
            second_line = false;
        }

        if (second_line) {
            // determine mark
            if (first_line < second_line) {
                sel_start = first_line;
                sel_end = second_line;
            } else {
                sel_start = second_line;
                sel_end = first_line;
            }
            window.location.href = org_href + '#L' + sel_start + '-L' + sel_end;
        } else {
            window.location.href = org_href + '#L' + first_line;
        }

        ST.highlight_lines();
    });

    ST.highlight_lines();

}

ST.highlight_lines = function() {
    var wloc = window.location.href;
    if (wloc.indexOf('#') > -1) {
        $('.container .CodeMirror li').css('background', 'none');

        var lines = wloc.split('#')[1];
        if (lines.indexOf('-') > -1) {
            var start_line = parseInt(lines.split('-')[0].replace('L', ''), 10);
            var end_line = parseInt(lines.split('-')[1].replace('L', ''), 10);
            for (var i = start_line; i <= end_line; i++) {
                $('.container .CodeMirror li:nth-child(' + i + ')').css('background', '#F8EEC7');
            }
        } else {
            var re = new RegExp('^L[0-9].*?$');
            var r = lines.match(re);
            if (r) {
                var marked_line = lines.replace('L', '');
                $('.container .CodeMirror li:nth-child(' + marked_line + ')').css('background', '#F8EEC7');
            }
        }
    }
}

ST.crypto = function() {
    $('button[name=submit]').after('&nbsp;&nbsp;<button type="submit" id="create_encrypted" class="btn-large btn-success"> <i class="icon-lock icon-white"></i> Create encrypted</button>');
    $('#create_encrypted').on('click', function() {
        var $code = $('#code');

        // save CM into textarea
        CM.editor.save();

        // encrypt the paste
        var key = ST.crypto_generate_key(32);
        var plaintext = $code.val();
        plaintext = LZString.compressToBase64(plaintext);
        var encrypted = CryptoJS.AES.encrypt(plaintext, key) + '';

        // linebreak after 100 chars
        encrypted = encrypted.replace(/(.{100})/g, "$1\n");

        // post request via JS
        $.post(base_url + 'post_encrypted', {
                'name': $('#name').val(),
                'title': $('#title').val(),
                'code': encrypted,
                'lang': $('#lang').val(),
                'expire': $('#expire').val(),
                'reply': $('input[name=reply]').val()
            },
            function(redirect_url) {
                if (redirect_url.indexOf('invalid') > -1) {
                    $('#create_encrypted').parent().html('<p>' + redirect_url + '#' + key + '</p>');
                } else {
                    window.location.href = base_url + redirect_url + '#' + key;
                }
            });

        return false;
    });

    // decryption routine
    w_href = window.location.href;
    if (w_href.indexOf('#') > -1) {
        key = w_href.split('#')[1];
        var re = new RegExp('^L[0-9].*?$');
        var r = key.match(re);
        if (key.indexOf('-') > -1 || r) {
            // line highlighter
        } else {
            try {
                var $code = $('#code');
                var encrypted = $code.val().replace(/\n/g, '');
                var decrypted = CryptoJS.AES.decrypt(encrypted, key).toString(CryptoJS.enc.Utf8) + '';
                decrypted = LZString.decompressFromBase64(decrypted);
                $code.val(decrypted);

                // add a breaking_space after 90 chars (for later)
                decrypted = decrypted.replace(/(.{90}.*?) /g, "$1{{{breaking_space}}}");

                // remove html entities
                decrypted = decrypted
                    .replace(/&/g, '&amp;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/ /g, '&nbsp;')
                    .replace(/{{{breaking_space}}}/g, ' ')
                    .replace(/\n/g, '<br />')

                $('section blockquote.CodeMirror div').html(decrypted);

                // kick out potential dangerous and unnecessary stuff
                $('section blockquote.CodeMirror div').css('background', '#efe');
                $('.replies').hide();
                for (var i = 2; i <= 5; i++) {
                    $('.meta .detail:nth-child(' + i + ')').hide();
                }
            } catch (e) {}
        }
    }
}

// generate a random key
ST.crypto_generate_key = function(len) {
    var index = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    var key = '';
    for (var i = 0; i < len; i++) {
        key += index[Math.floor(Math.random() * index.length)]
    };
    return key;
}

$(document).ready(function() {
    ST.init();
    CM.init();
    ST.line_highlighter();
    ST.crypto();
});
