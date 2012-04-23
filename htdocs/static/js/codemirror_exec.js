var CM = window.CM || {}

CM.enabled = false;

CM.init = function() {
	CM.modes = $.parseJSON($('#codemirror_modes').text());
	$enable_codemirror = $('#enable_codemirror');

	if (typeof CM.editor == 'undefined') {
		CM.editor = CodeMirror.fromTextArea(document.getElementById('code'), {
			lineNumbers: true,
			lineWrapping: true,
		});
	}

	$enable_codemirror.click(function() {

		//todo: no rebind
		$('#lang').change(function() {
			CM.set_language();
		});

		CM.toggle();
	});
};

CM.toggle = function() {
	if (CM.enabled) {
		CM.editor.toTextArea();
        CM.editor = undefined;
		CM.enabled = false;
	} else {
		CM.init();
		CM.enabled = true;
	}
	return false;
};

CM.set_language = function() {
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
	CM.editor.setOption('mode', mode);
};

$(document).ready(function() {
	CM.init();
});
