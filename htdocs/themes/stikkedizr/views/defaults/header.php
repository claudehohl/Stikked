<!DOCTYPE html>
<?php
$page_title = '';
if(isset($title))
{
    $page_title .= $title . ' - ';
}
$page_title .= $this->config->item('site_name');
?>
<html lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title><?php echo $page_title; ?></title>
<?php

//Carabiner
$this->carabiner->config(array(
    'script_dir' => 'themes/stikkedizr/js/',
    'style_dir'  => 'themes/stikkedizr/css/',
    'cache_dir'  => 'static/asset/',
    'base_uri'	 => base_url(),
    'combine'	 => true,
    'dev'		 => !$this->config->item('combine_assets'),
));

// CSS
$this->carabiner->css('bootstrap.min.css');
$this->carabiner->css('font-awesome.min.css');
$this->carabiner->css('style.css');
$this->carabiner->css('codemirror.css');

$this->carabiner->display('css');

// Captcha
if($this->use_recaptcha) {
  echo "<script src='https://www.google.com/recaptcha/api.js'></script>";
}
?>
	<script type="text/javascript">
	//<![CDATA[
	var base_url = '<?php echo base_url(); ?>';
	//]]>
	</script>
	</head>
	<body>
		<header>
			<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#stikked-nav">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> <?php echo $this->config->item('site_name'); ?></a>
					</div>
					<div class="collapse navbar-collapse" id="stikked-nav">
						<ul class="nav navbar-nav">
							<?php $l = $this->uri->segment(1)?>
							<li><a <?php if($l == ""){ echo 'class="active"'; }?> href="<?php echo base_url()?>" title="<?php echo lang('menu_create_title'); ?>"><i class="fa fa-plus-circle"></i> <?php echo lang('menu_create'); ?></a></li>
							<?php if(!$this->config->item('private_only')){ ?>
								<li><a <?php if($l == "lists" || $l == "view" and $this->uri->segment(2) != "options"){ echo 'class="active"'; }?> href="<?php echo site_url('lists'); ?>" title="<?php echo lang('menu_recent_title'); ?>"><i class="fa fa-rss-square"></i> <?php echo lang('menu_recent'); ?></a></li>
								<li><a <?php if($l == "trends"){ echo 'class="active"'; }?> href="<?php echo site_url('trends'); ?>" title="<?php echo lang('menu_trending_title'); ?>"><i class="fa fa-star"></i> <?php echo lang('menu_trending'); ?></a></li>
							<?php } ?>
							<?php if(! $this->config->item('disable_api')){ ?>
								<li><a  <?php if($l == "api"){ echo 'class="active"'; }?> href="<?php echo site_url('api'); ?>" title="<?php echo lang('menu_api'); ?>"><i class="fa fa-gear"></i> <?php echo lang('menu_api'); ?></a></li>
							<?php } ?>
							<li><a  <?php if($l == "about"){ echo 'class="active"'; }?> href="<?php echo site_url('about'); ?>" title="<?php echo lang('menu_about'); ?>"><i class="fa fa-info-circle"></i> <?php echo lang('menu_about'); ?></a></li>
						</ul>
					</div>
				</div>
			</nav>
		</header>

		<div class="container">
				<?php if(isset($status_message)){?>
				<div class="message success change">
					<div class="container">
						<?php echo $status_message; ?>
					</div>
				</div>
				<?php }?>
