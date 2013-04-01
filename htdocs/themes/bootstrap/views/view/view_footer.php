		<?php $this->load->view('defaults/footer_message'); ?>
<?php

//codemirror modes
echo '<div style="display: none;" id="codemirror_modes">' . json_encode($codemirror_modes) . '</div>';

//stats
$this->load->view('defaults/stats');

//Javascript
$this->carabiner->js('jquery.js');
$this->carabiner->js('bootstrap.min.js');
$this->carabiner->js('jquery.timers.js');
//$this->carabiner->js('jquery.dataTables.min.js');
$this->carabiner->js('codemirror/lib/codemirror.js');


$this->carabiner->js('stikked.js');

$this->carabiner->display('js');

?>
<script>
</script>
	</body>
</html>
