<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
$page_title = '';
if(isset($title))
{
    $page_title .= $title . ' - ';
}
$page_title .= $this->config->item('site_name');
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title><?php echo $page_title; ?></title>
<?php

//Carabiner
$this->carabiner->config(array(
    'script_dir' => 'static/js/', 
    'style_dir'  => 'static/styles/',
    'cache_dir'  => 'static/asset/',
    'base_uri'	 => base_url(),
    'combine'	 => true,
    'dev'		 => !$this->config->item('combine_assets'),
));

// CSS
$this->carabiner->css('reset.css');
$this->carabiner->css('fonts.css');
$this->carabiner->css('main.css');
$this->carabiner->css('codemirror.css');
$this->carabiner->css('diff.css');

$this->carabiner->display('css'); 

?>
	<script type="text/javascript">
	//<![CDATA[
	var base_url = '<?php echo base_url(); ?>';
	//]]>
	</script>
	</head>
	<body>
		<div id="container">
			<div class="container">			
				<div class="header">
					<h1><a href="<?php echo base_url(); ?>" class="title"><?php echo $this->config->item('site_name'); ?></a></h1>
					<ul class="tabs">
						<?php $l = $this->uri->segment(1)?>
						<li><a <?php if($l == ""){ echo 'class="active"'; }?> href="<?php echo base_url()?>" title="Create A New Paste">Create</a></li>
<?php if(!$this->config->item('private_only')){ ?>
						<li><a <?php if($l == "lists" || $l == "view" and $this->uri->segment(2) != "options"){ echo 'class="active"'; }?> href="<?php echo site_url('lists'); ?>" title="Recent Pastes">Recent</a></li>
<?php } ?>
						<li><a  <?php if($l == "api"){ echo 'class="active"'; }?> href="<?php echo site_url('api'); ?>" title="API">API</a></li>
						<li><a  <?php if($l == "about"){ echo 'class="active"'; }?> href="<?php echo site_url('about'); ?>" title="About">About</a></li>
					</ul>
				</div>

				<div class="content">
					<div class="container">
						<?php if(isset($status_message)){?>
						<div class="message success change">
							<div class="container">
								<?php echo $status_message; ?>
							</div>
						</div>
						<?php }?>				
