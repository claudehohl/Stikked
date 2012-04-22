var CM = window.CM || {}

CM.on = false;
CM.mode = 'php';

CM.init = function() {
	if (CM.on) {
		CM.editor.toTextArea();
		CM.on = false;
	} else {
		CM.editor = CodeMirror.fromTextArea(document.getElementById('code'), {
			mode: CM.mode, //$('#codemirror_mode').text(),
			lineNumbers: true,
			lineWrapping: true,
		});
		CM.on = true;
		if (CM.mode == 'php') {
			CM.mode = 'javascript';
		}
	}
};

$(document).ready(function() {
	$enable_codemirror = $('#enable_codemirror');
	$enable_codemirror.click(function() {
		CM.init();
		//$enable_codemirror.remove();
		return false;
	});
});
