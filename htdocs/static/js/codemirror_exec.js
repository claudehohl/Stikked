var CM = window.CM || {}

CM.init = function() {
	var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
		mode: "application/x-httpd-php",
		lineNumbers: true,
		lineWrapping: true,
		onCursorActivity: function() {
			editor.setLineClass(hlLine, null, null);
			hlLine = editor.setLineClass(editor.getCursor().line, null, "activeline");
		}
	});
	var hlLine = editor.setLineClass(0, "activeline");
};

$(document).ready(function() {
	CM.init();
});
