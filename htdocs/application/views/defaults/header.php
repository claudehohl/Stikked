<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title><?php echo $this->config->item('site_name');?></title>
<?php

//Carabiner
$this->carabiner->config(array(
    'script_dir' => 'static/js/', 
    'style_dir'  => 'static/styles/',
    'cache_dir'  => 'static/asset/',
    'base_uri'	 => base_url(),
    'combine'	 => true,
    //'dev'		 => true,
));

// CSS
$this->carabiner->css('reset.css');
$this->carabiner->css('fonts.css');
$this->carabiner->css('main.css');

$this->carabiner->display('css'); 

?>
	</head>
	<body>
		<div id="container">
			<div class="container">			
				<div class="header">
					<h1><a href="<?php echo base_url(); ?>" class="title"><?php echo $this->config->item('site_name');?></a></h1>
					<ul class="tabs">
						<?php $l = $this->uri->segment(1)?>
						<li><a <?php if($l == ""){ echo 'class="active"'; }?> href="<?php echo base_url()?>" title="Create A New Paste">Create</a></li>
						<li><a <?php if($l == "lists" || $l == "view" and $this->uri->segment(2) != "options"){ echo 'class="active"'; }?> href="<?php echo site_url("lists"); ?>" title="Recent Pastes">Recent</a></li>
						<li><a  <?php if($l == "about"){ echo 'class="active"'; }?> href="<?php echo site_url("about/"); ?>" title="About Paste.mycodenow.com">About</a></li>
					</ul>
				</div>

				<div class="content">
					<div class="container">
						<?php if(isset($status_message)){?><script type="text/javascript" charset="utf-8">
							$(document).ready(function(){
								$(".change").oneTime(3000, function() {
								$(this).fadeOut(2000);
							});						
						});</script>
						<div class="message success change">
							<div class="container">
								<?php echo $status_message; ?>
							</div>
						</div>
						<?php }?>				
