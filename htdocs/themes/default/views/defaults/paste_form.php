<?php echo validation_errors(); ?>

<div class="form_wrapper margin">
	<form action="<?php echo base_url(); ?>" method="post">

		<h1><?php if(!isset($page['title'])){ ?>
			<?php echo lang('paste_create_new'); ?>
		<?php } else { ?>
			<?php echo $page['title']; ?>
		<?php } ?></h1>
		<p class="explain border"><?php if(!isset($page['instructions'])){ ?>
			<?php echo lang('paste_create_new_desc'); ?>
		<?php } else { ?>
			<?php echo $page['instructions']; ?>
		<?php } ?></p>

		<div class="item_group">
			<div class="item">
				<label for="name"><?php echo lang('paste_author'); ?>
					<span class="instruction"><?php echo lang('paste_author_desc'); ?></span>
				</label>
				<?php $set = array('name' => 'name', 'id' => 'name', 'value' => $name_set, 'maxlength' => '32', 'tabindex' => '1');
				echo form_input($set);?>
			</div>
			<div class="item">
				<label for="title"><?php echo lang('paste_title'); ?>
					<span class="instruction"><?php echo lang('paste_title_desc'); ?></span>
				</label>
				<input value="<?php if(isset($title_set)){ echo $title_set; }?>" type="text" id="title" name="title" tabindex="2" maxlength="50" />
			</div>

			<div class="item last">
				<label for="lang"><?php echo lang('paste_lang'); ?>
					<span class="instruction"><?php echo lang('paste_lang_desc'); ?></span>
				</label>
				<?php $lang_extra = 'id="lang" class="select" tabindex="3"'; echo form_dropdown('lang', $languages, $lang_set, $lang_extra); ?>
			</div>
		</div>

		<div class="item">
			<label for="paste"><?php echo lang('paste_yourpaste'); ?>
				<span class="instruction"><?php echo lang('paste_yourpaste_desc'); ?></span>
                <span class="instruction"><a href="#" id="enable_codemirror" data-lang-enablesynhl="<?php echo lang('paste_enablesynhl'); ?>" data-lang-disablesynhl="<?php echo lang('paste_disablesynhl'); ?>"></a></span>
			</label>

			<textarea id="code" name="code" cols="40" rows="20" tabindex="4"><?php if(isset($paste_set)){ echo $paste_set; }?></textarea>

		</div>

		<div class="item_group">
			<div class="item">
				<label for="snipurl"><?php echo lang('paste_create_shorturl'); ?>
					<span class="instruction"><?php echo lang('paste_shorturl_desc'); ?></span>
				</label>
				<div class="text_beside">
					<?php
						$set = array('name' => 'snipurl', 'id' => 'snipurl', 'value' => '1', 'tabindex' => '5', 'checked' => $snipurl_set);
						if ($this->config->item('disable_shorturl')){
							$set['checked'] = 0;
							$set['disabled'] = 'disabled';
						}
						echo form_checkbox($set);
					?>
				</div>
			</div>

			<div class="item">
				<label for="private"><?php echo lang('paste_private'); ?>
					<span class="instruction"><?php echo lang('paste_private_desc'); ?></span>
				</label>
				<div class="text_beside">
					<?php
						$set = array('name' => 'private', 'id' => 'private', 'tabindex' => '6', 'value' => '1', 'checked' => $private_set);
                        if ($this->config->item('private_only')){
                            $set['checked'] = 1;
                            $set['disabled'] = 'disabled';
                        }
						echo form_checkbox($set);
					?>
				</div>
			</div>

			<div class="item">
				<label for="expire"><?php echo lang('paste_delete'); ?>
					<span class="instruction"><?php echo lang('paste_delete_desc'); ?></span>
				</label>
				<?php
					$expire_extra = 'id="expire" class="select" tabindex="7"';
                    $default_expiration = config_item('default_expiration');
					$options = array(
									"burn" => lang('exp_burn'),
									"5" => lang('exp_5min'),
									"60" => lang('exp_1h'),
									"1440" => lang('exp_1d'),
									"10080" => lang('exp_1w'),
									"40320" => lang('exp_1m'),
									"483840" => lang('exp_1y'),
								);
                    if(! config_item('disable_keep_forever')) {
                        $options['0'] = lang('exp_forever');
                    }
				echo form_dropdown('expire', $options, $default_expiration, $expire_extra); ?>
			</div>
		</div>

<?php if($reply){ ?>
		<input type="hidden" value="<?php echo $reply; ?>" name="reply" />
<?php } ?>

<?php if($this->config->item('enable_captcha') && $this->session->userdata('is_human') === null){ ?>
		<div class="item_group">
			<div class="item item_captcha">
				<label for="captcha"><?php echo lang('paste_spam'); ?>
					<span class="instruction"><?php echo lang('paste_spam_desc'); ?></span>
				</label>
<?php if($use_recaptcha){
    echo recaptcha_get_html($recaptcha_publickey, null, stristr(base_url(), 'https'));
} else { ?>
                <img class="captcha" src="<?php echo site_url('view/captcha'); ?>?<?php echo date('U', time()); ?>" alt="captcha" width="180" height="40" />
                <input value="" type="text" id="captcha" name="captcha" tabindex="2" maxlength="32" />
<?php } ?>
			</div>
		</div>
<?php } ?>

<?php
    $set = array('name' => 'email', 'class' => 'email');
    echo form_input($set);
    $set = array('name' => 'url', 'class' => 'url');
    echo form_input($set);
?>

		<div class="clear"><button type="submit" value="submit" name="submit"><?php echo lang('paste_create'); ?></button></div>
		<?php
		if ($this->config->item('csrf_protection') === TRUE)
		{
			if(isset($_COOKIE[$this->config->item('csrf_cookie_name')])) {
				echo '<input type="hidden" name="'.$this->config->item('csrf_token_name').'" value="'.html_escape($_COOKIE[$this->config->item('csrf_cookie_name')]).'" style="display:none;" />'."\n";
			}
		}
		?>
		<div class="spacer"></div>

	</form>
</div>
