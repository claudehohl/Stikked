					</div>
				</div>
			<?php $this->load->view('defaults/footer_message'); ?>
			</div>
		</div>	
		<?php $this->load->view("defaults/stats")?>
<?php

//Javascript
$this->carabiner->js('jquery.js');
$this->carabiner->js('jquery.timers.js');
$this->carabiner->js('jquery.clipboard.js');

$this->carabiner->display('js');

?>
	</body>
</html>
