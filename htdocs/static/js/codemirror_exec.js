var CM = window.CM || {}


CM.init = function() {
	//CM.editor.toTextArea();
	var lang = $('#lang').val();
    console.info(lang);
	if (typeof CM.editor == 'undefined') {
		CM.editor = CodeMirror.fromTextArea(document.getElementById('code'), {
			mode: CM.mode,
			lineNumbers: true,
			lineWrapping: true,
		});
	}
};

$(document).ready(function() {
	$enable_codemirror = $('#enable_codemirror');
	$enable_codemirror.click(function() {
		CM.init();
		$enable_codemirror.remove();
		return false;
	});
	$('#lang').change(function() {
		CM.init();
	});
});
