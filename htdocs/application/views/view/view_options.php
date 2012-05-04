<?php $this->load->view("defaults/header"); ?>

<div class="form_wrapper margin full">
	<form action="<?php echo site_url("view/options"); ?>" method="post">

		<h1>Change paste viewing options</h1>
		<p class="explain border">Here you can change your preferences for viewing pastes. Requires cookies to be enabled.</p>								
										
		<div class="item">
			<label for="full_width">Expand Pastes
				<span class="instruction">This automatically expands the width of a paste to fill the whole page.</span>
			</label>
			<div class="text_beside">
			<?php
			$set = array('name' => 'full_width', 'id' => 'full_width', 'value' => '1', 'checked' => $full_width_set);
			echo form_checkbox($set);
			?>
			<p>Expand Pastes by default</p>
			</div>
		</div>
		<div><button type="submit" value="submit" name="submit">Save</button></div>
		<div class="spacer"></div>
	</form>
</div>

<?php $this->load->view("defaults/footer.php"); ?>
