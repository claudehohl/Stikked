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
	init: function () {
		var txtAreas = $("textarea").length;

		if(txtAreas > 0) {
			modes = $.parseJSON($('#codemirror_modes').text());
		
		
			var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
				mode: "scheme",
				lineNumbers: true,
				matchBrackets: true,
				tabMode: "indent"
			});
		
			$('#lang').change(function() {
					set_language();
			});
		
			set_syntax = function(mode) {
				editor.setOption('mode', mode);
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

    $('blockquote').on('mousedown', function() {
        window.getSelection().removeAllRanges();
    });

    $('blockquote').on('click', 'li', function(ev) {
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
        $('blockquote li').css('background', 'none');

        var lines = wloc.split('#')[1];
        if(lines.indexOf('-') > -1) {
            var start_line = parseInt(lines.split('-')[0].replace('L', ''), 10);
            var end_line = parseInt(lines.split('-')[1].replace('L', ''), 10);
            for(var i=start_line; i<=end_line; i++) {
                $('blockquote li:nth-child(' + i + ')').css('background', '#F8EEC7');
            }
        } else {
            var marked_line = lines.replace('L', '');
            $('blockquote li:nth-child(' + marked_line + ')').css('background', '#F8EEC7');
        }
    }
}

$(document).ready(function() {
	ST.init();
	CM.init();
	ST.line_highlighter();
});
