		<?php $this->load->view('defaults/footer_message.php'); ?>
<?php
$this->load->view('defaults/stats');

//Javascript
$this->carabiner->js('jquery.js');
$this->carabiner->js('jquery.timers.js');
$this->carabiner->js('jquery.clipboard.js');
$this->carabiner->js('stikked.js');
$this->carabiner->js('codemirror/codemirror.js');
$this->carabiner->js('codemirror/mode/xml/xml.js');
$this->carabiner->js('codemirror/mode/javascript/javascript.js');
$this->carabiner->js('codemirror/mode/css/css.js');
$this->carabiner->js('codemirror/mode/clike/clike.js');
$this->carabiner->js('codemirror/mode/php/php.js');

$this->carabiner->display('js');

?>
<script>
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
</script>
	</body>
</html>
