var CM = window.CM || {}

CM.init = function() {
	var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
		mode: $('#codemirror_mode').text(),
		lineNumbers: true,
		lineWrapping: true,
	});
};

$(document).ready(function() {
	CM.init();
});
