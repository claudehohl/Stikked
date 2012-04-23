var CM = window.CM || {}

CM.enabled = false;

CM.init = function() {
	CM.modes = $.parseJSON($('#codemirror_modes').text());
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
};

CM.set_syntax = function(mode) {
	if (typeof CM.editor == 'undefined') {
		CM.editor = CodeMirror.fromTextArea(document.getElementById('code'), {
			mode: mode,
			lineNumbers: true,
			lineWrapping: true,
		});
	} else {
		CM.editor.setOption('mode', mode);
	}
};

$(document).ready(function() {
	$enable_codemirror = $('#enable_codemirror');
	$enable_codemirror.click(function() {
		$('#lang').change(function() {
			CM.init();
		});
		if (CM.enabled) {
			CM.editor.toTextArea()
			CM.enabled = false;
		} else {
			CM.init();
			CM.enabled = true;
		}
		return false;
	});
});
