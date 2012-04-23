var CM = window.CM || {}

CM.enabled = false;

CM.init = function() {
	CM.modes = $.parseJSON($('#codemirror_modes').text());
	$('#enable_codemirror').click(function() {
		$('#lang').change(function() {
			CM.set_language();
		});
		CM.toggle();
		CM.set_language();
		return false;
	});
};

CM.toggle = function() {
	if (CM.enabled) {
		CM.editor.toTextArea();
		CM.editor = undefined;
		$('#lang').unbind();
		$('#enable_codemirror').text('Enable syntax highlighting');
		CM.enabled = false;
	} else {
		if (typeof CM.editor == 'undefined') {
			CM.editor = CodeMirror.fromTextArea(document.getElementById('code'), {
				lineNumbers: true,
				lineWrapping: true,
			});
		}
		$('#enable_codemirror').text('Disable syntax highlighting');
		CM.enabled = true;
	}
};

CM.set_language = function() {
	if (CM.enabled) {
		var lang = $('#lang').val();
		mode = CM.modes[lang];

		$.get(base_url + 'main/get_cm_js/' + lang,
		function(data) {
			if (data != '') {
				CM.set_syntax(mode);
			} else {
				CM.set_syntax(null);
			}
		},
		'script');
	}
};

CM.set_syntax = function(mode) {
	CM.editor.setOption('mode', mode);
};

$(document).ready(function() {
	CM.init();
});
