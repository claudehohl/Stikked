		<?php $this->load->view('defaults/footer_message.php'); ?>
<?php

//codemirror modes
echo '<div style="display: none;" id="codemirror_modes">' . json_encode($codemirror_modes) . '</div>';

//stats
$this->load->view('defaults/stats');

//Javascript
$this->carabiner->js('jquery.js');
$this->carabiner->js('jquery.timers.js');
$this->carabiner->js('jquery.clipboard.js');
$this->carabiner->js('stikked.js');
$this->carabiner->js('codemirror/codemirror.js');
$this->carabiner->display('js');

if(isset($codemirror_languages[$lang_set]) && gettype($codemirror_languages[$lang_set]) == 'array')
{
    $codemirror_specific = array(
        'js' => $codemirror_languages[$lang_set]['js'],
    );
    $codemirror_specific['js'][] = array('codemirror_exec.js');
    $this->carabiner->group('codemirror', $codemirror_specific);
    $this->carabiner->display('codemirror');

}

?>
<script>
</script>
	</body>
</html>
