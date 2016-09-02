			<?php $this->load->view('defaults/footer_message'); ?>
		</div>
<?php

//codemirror modes
if(isset($codemirror_modes)){
    echo '<div style="display: none;" id="codemirror_modes">' . json_encode($codemirror_modes) . '</div>';
}

//stats
$this->load->view('defaults/stats');

//Javascript
$this->carabiner->js('jquery.js');
$this->carabiner->js('jquery.timers.js');
$this->carabiner->js('crypto-js/rollups/aes.js');
$this->carabiner->js('lz-string-1.3.3-min.js');
$this->carabiner->js('filereader.js');
$this->carabiner->js('stikked.js');
$this->carabiner->js('codemirror/codemirror.js');
$this->carabiner->js('codemirror_exec.js');

$this->carabiner->display('js');

?>
	</body>
</html>
