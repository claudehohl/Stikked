
<?php echo validation_errors(); ?>

<div class="row">
	<div class="span12">
		<div class="page-header">
			<h1><?php if(!isset($page['title'])){ ?>
			Create a new paste
			<?php } else { ?>
				<?php echo $page['title']; ?>
			<?php } ?>
			
			</h1>
		</div>
		
	</div>
	<div class="span12">
		<form action="<?php echo base_url(); ?>" method="post" class="form-vertical well">
			<div class="row">
				<div class="span3">
					<label for="name">Author
					</label>
					
					<?php $set = array('name' => 'name', 'id' => 'name', 'class' => 'span3', 'value' => $name_set, 'maxlength' => '32', 'tabindex' => '1');
					echo form_input($set);?>
				</div>
				
				<div class="span3">
					<label for="title">
						Title
					</label>
					
					<input value="<?php if(isset($title_set)){ echo $title_set; }?>" class="span3" type="text" id="title" name="title" tabindex="2" maxlength="32" />
				</div>
		
				<div class="span3">
					<label for="lang">
						Language
					</label>
					<?php $lang_extra = 'id="lang" class="select span3" tabindex="3"'; echo form_dropdown('lang', $languages, $lang_set, $lang_extra); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="span12">
					<label for="paste">Your paste
						<span class="instruction">Paste your paste here</span>
					</label>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<textarea id="code" class="span12" name="code" rows="20" tabindex="4"><?php if(isset($paste_set)){ echo $paste_set; }?></textarea>
				</div>
			</div>

			<div class="row">
				<div class="span8">
					<div class="control-group">
						<label class="control-label" for="optionsCheckbox">Create Shorturl</label>
						<div class="controls">
							<label class="checkbox">
								<?php
									$set = array('name' => 'snipurl', 'id' => 'snipurl', 'value' => '1', 'tabindex' => '5', 'checked' => $snipurl_set);
									echo form_checkbox($set);
								?>
								Create a shorter url that redirects to your paste?
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="optionsCheckbox">Private</label>
						<div class="controls">
							<label class="checkbox">
								<?php
								$set = array('name' => 'private', 'id' => 'private', 'tabindex' => '6', 'value' => '1', 'checked' => $private_set);
										if ($this->config->item('private_only')){
											$set['checked'] = 1;
											$set['disabled'] = 'disabled';
											}
								echo form_checkbox($set);
							?>
								Private paste aren't shown in recent listings.
							</label>
						</div>
					</div>
					<div class="item">
						<label for="expire">Delete After
							<span class="instruction">When should we delete your paste?</span>
						</label>
						<?php 
							$expire_extra = 'id="expire" class="select" tabindex="7"';
							$options = array(
											"0" => "Keep Forever",
											"30" => "30 Minutes",
											"60" => "1 hour",
											"360" => "6 Hours",
											"720" => "12 Hours",
											"1440" => "1 Day",
											"10080" => "1 Week",
											"40320" => "4 Weeks"
										);
						echo form_dropdown('expire', $options, $expire_set, $expire_extra); ?>
					</div>
				</div>
			</div>
			
		<?php if($reply){ ?>
			<input type="hidden" value="<?php echo $reply; ?>" name="reply" />
		<?php } ?>
		
		<?php if($this->config->item('enable_captcha')){ ?>
			<div class="item_group">
				<div class="item item_captcha">
					<label for="captcha">Spam Protection
						<span class="instruction">Type in the characters displayed in the picture.</span>
					</label>
						<img class="captcha" src="<?php echo site_url('view/captcha'); ?>?<?php echo date('U', mktime()); ?>" alt="captcha" width="110" height="40" />
						<input value="<?php if(isset($captcha_set)){ echo $captcha_set; }?>" type="text" id="captcha" name="captcha" tabindex="2" maxlength="32" />
				</div>
			</div>
		<?php } ?>
			<div class="form-actions">
				<button type="submit" name="submit" value="submit" class="btn-large btn-primary">
					<i class="icon-pencil icon-white"></i>
					 Create
				</button>
			</div>
		</form>
	</div>
</div>
