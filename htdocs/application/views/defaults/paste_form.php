
<?php echo validation_errors(); ?>

<div class="form_wrapper margin">
	<form action="<?php echo base_url(); ?>" method="post">

		<h1><?php if(!isset($page['title'])){ ?>
			Create a new paste
		<?php } else { ?>
			<?php echo $page['title']; ?>
		<?php } ?></h1>
		<p class="explain border"><?php if(!isset($page['instructions'])){ ?>
			Here you can create a new paste
		<?php } else { ?>
			<?php echo $page['instructions']; ?>
		<?php } ?></p>								
		
		<div class="item_group">								
			<div class="item">
				<label for="name">Author
					<span class="instruction">What's your name?</span>
				</label>
				
				<?php $set = array('name' => 'name', 'id' => 'name', 'value' => $name_set, 'maxlength' => '32', 'tabindex' => '1');
				echo form_input($set);?>
			</div>
			
			<div class="item">
				<label for="title">Title
					<span class="instruction">Give your paste a title.</span>
				</label>
				
				<input value="<?php if(isset($title_set)){ echo $title_set; }?>" type="text" id="title" name="title" tabindex="2" maxlength="32" />
			</div>
																		
			<div class="item last">
				<label for="lang">Language
					<span class="instruction">What language is your paste written in?</span>
				</label>
				
				<?php $lang_extra = 'id="lang" class="select" tabindex="3"'; echo form_dropdown('lang', $languages, $lang_set, $lang_extra); ?>
			</div>								
		</div>							
		
		<div class="item">
			<label for="paste">Your paste
				<span class="instruction">Paste your paste here</span>
                <span class="instruction"><a href="#" id="enable_codemirror">Enable syntax highlighting</a></span>
			</label>
			
			<textarea id="code" name="code" cols="40" rows="20" tabindex="4"><?php if(isset($paste_set)){ echo $paste_set; }?></textarea>
		</div>																											
		
		<div class="item_group">
			<div class="item">
				<label for="snipurl">Create Shorturl
					<span class="instruction">Create a shorter url that redirects to your paste?</span>
				</label>
				<div class="text_beside">
					<?php
						$set = array('name' => 'snipurl', 'id' => 'snipurl', 'value' => '1', 'tabindex' => '5', 'checked' => $snipurl_set);
						echo form_checkbox($set);
					?>
				</div>
			</div>
		
			<div class="item">
<?php if (!$this->config->item('private_only')){ ?>
				<label for="private">Private
					<span class="instruction">Private paste aren't shown in recent listings.</span>
				</label>
				<div class="text_beside">
					<?php
						$set = array('name' => 'private', 'id' => 'private', 'tabindex' => '6', 'value' => '1', 'checked' => $private_set);
						echo form_checkbox($set);
					?>
				</div>
<?php } ?>
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
									"100080" => "1 Week",
									"40320" => "4 Weeks"
								);
				echo form_dropdown('expire', $options, $expire_set, $expire_extra); ?>
			</div>
		</div>
		
		<?php if($reply){?>
		<input type="hidden" value="<?php echo $reply; ?>" name="reply" />
		<?php }?>

		<div class="item_group">
			<div class="item item_captcha">
				<label for="captcha">Spam Protection
					<span class="instruction">Type in the characters displayed in the picture.</span>
				</label>
                <img class="captcha" src="<?php echo site_url('view/captcha'); ?>" alt="captcha" />
                <input value="<?php if(isset($title_set)){ echo $title_set; }?>" type="text" id="title" name="title" tabindex="2" maxlength="32" />
			</div>
		</div>

		<div><button type="submit" value="submit" name="submit">Create</button></div>
		<div class="spacer"></div>
	</form>
</div>
