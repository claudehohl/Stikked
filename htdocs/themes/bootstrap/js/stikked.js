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

$(document).ready(function() {
	ST.init();
	CM.init();
});
