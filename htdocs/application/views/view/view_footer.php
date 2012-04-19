		<?php $this->load->view('defaults/footer_message.php'); ?>
<?php
$this->load->view('defaults/stats');

//Javascript
$this->carabiner->js('jquery.js');
$this->carabiner->js('jquery.timers.js');
$this->carabiner->js('jquery.clipboard.js');
$this->carabiner->js('stikked.js');
$this->carabiner->js('codemirror/codemirror.js');
$this->carabiner->display('js');

$codemirror_specific = array(
    'js' => array(
        array('codemirror/mode/xml/xml.js'),
        array('codemirror/mode/javascript/javascript.js'),
        array('codemirror/mode/css/css.js'),
        array('codemirror/mode/clike/clike.js'),
        array('codemirror/mode/php/php.js'),
    )
);

$codemirror_specific['js'][] = array('codemirror_exec.js');

$this->carabiner->group('codemirror', $codemirror_specific);

$this->carabiner->display('codemirror');

?>
<script>
</script>
	</body>
</html>
