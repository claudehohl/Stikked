var ST = window.ST || {}

ST.show_embed = function() {
	$embed_field = $('#embed_field');
    var lang_showcode = $embed_field.data('lang-showcode');
	$embed_field.hide();
	$embed_field.after('<a id="show_code" href="#">' + lang_showcode + '</a>');
	$('#show_code').live('click',
	function() {
		$(this).hide();
		$embed_field.show().select();
		return false;
	});
};

ST.expand = function() {
    $('.expander').show();
	$('.expand').click(function() {
		if ($('.paste').hasClass('full')) {
			return false;
		}
		var window_width = $(window).width();
		var spacer = 20;
		if (window_width < 900) {
			window_width = 900;
			spacer = 0;
		}
		var new_width = (window_width - (spacer * 3));
		$('.text_formatted').animate({
			'width': new_width + 'px',
			'left': '-' + (((window_width - 900) / 2 - spacer)) + 'px'
		},
		200);
		return false;
	});
};

ST.spamadmin = function() {
	if ($('.content h1').text() == 'Spamadmin') {
        $('.content .hidden').show();
        $('.content .quick_remove').live('click', function(ev) {
            var ip = $(ev.target).data('ip');
            if (confirm('Delete all pastes belonging to ' + ip + '?')) {
                $.post(base_url + 'spamadmin/' + ip, { 'confirm_remove': 'yes', 'block_ip': 1 }, function() {
                    window.location.reload();
                });
            }
            return false;
        });
    }
};

ST.line_highlighter = function() {
    var org_href = window.location.href.replace(/(.*?)#(.*)/, '$1');
    var first_line = false;
    var second_line = false;

    $('.text_formatted').on('mousedown', function() {
        window.getSelection().removeAllRanges();
    });

    $('.text_formatted').on('click', 'li', function(ev) {
        var $this = $(this);
        var li_num = ($this.index() + 1);
        if(ev.shiftKey == 1){
            second_line = li_num;
        } else {
            first_line = li_num;
            second_line = false;
        }

        if(second_line){
            // determine mark
            if(first_line < second_line) {
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
    if(wloc.indexOf('#') > -1) {
        $('.text_formatted .container li').css('background', 'none');

        var lines = wloc.split('#')[1];
        if(lines.indexOf('-') > -1) {
            var start_line = parseInt(lines.split('-')[0].replace('L', ''), 10);
            var end_line = parseInt(lines.split('-')[1].replace('L', ''), 10);
            for(var i=start_line; i<=end_line; i++) {
                $('.text_formatted .container li:nth-child(' + i + ')').css('background', '#F8EEC7');
            }
        } else {
            var re = new RegExp('^L[0-9].*?$');
            var r = lines.match(re);
            if(r) {
                var marked_line = lines.replace('L', '');
                $('.text_formatted .container li:nth-child(' + marked_line + ')').css('background', '#F8EEC7');
            }
        }
    }
}

ST.crypto = function() {
    $('button[name=submit]').after('<button id="create_encrypted">Create encrypted</button>');
    $('#create_encrypted').on('click', function() {
        var $code = $('#code');

        // encrypt the paste
        var key = ST.crypto_generate_key(25);
        var encrypted = CryptoJS.AES.encrypt($code.val(), key) + '';

        // linebreak after 100 chars
        encrypted = encrypted.replace(/(.{100})/g, "$1\n");

        // post request via JS
        $.post(base_url + '/post_encrypted', {
            'name': $('#name').val(),
            'title': $('#title').val(),
            'code': encrypted,
            'lang': $('#lang').val(),
            'expire': $('#expire').val(),
            'reply': $('input[name=reply]').val()
        },
        function(redirect_url) {
            window.location.href = base_url + redirect_url + '#' + key;
        });

        return false;
    });

    // decryption routine
    w_href = window.location.href;
    if(w_href.indexOf('#') > -1) {
        key = w_href.split('#')[1];
        var re = new RegExp('^L[0-9].*?$');
        var r = key.match(re);
        if(key.indexOf('-') > -1 || r) {
            // line highlighter
        } else {
            try {
                var $code = $('#code');
                var encrypted = $code.val().replace(/\n/g, '');
                var decrypted = CryptoJS.AES.decrypt(encrypted, key).toString(CryptoJS.enc.Utf8) + '';
                $code.val(decrypted);
                $('.text_formatted .container div').html(decrypted
                    .replace(/&/g,"&amp;")
                    .replace(/"/g,"&quot;")
                    .replace(/'/g,"&#039;")
                    .replace(/</g,"&lt;")
                    .replace(/>/g,"&gt;")
                    .replace(/ /g, '&nbsp;')
                    .replace(/\n/g, '<br />')
                );
                $('.text_formatted').css('background', '#efe');
            } catch(e) {}
        }
    }
}

// generate a random key
ST.crypto_generate_key = function(len) {
	var index = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	var key = '';
	for(var i=0; i<len; i++) {
        key += index[Math.floor(Math.random()*index.length)]
    };
	return key;
}

ST.init = function() {
	ST.expand();
	ST.show_embed();
	ST.spamadmin();
	ST.line_highlighter();
	ST.crypto();
};

$(document).ready(function() {
	ST.init();
});
