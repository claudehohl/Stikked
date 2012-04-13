<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title><?php echo $this->config->item('site_name');?></title>
		<link rel="stylesheet" href="<?=base_url()?>static/styles/reset.css" type="text/css" />
		<link rel="stylesheet" href="<?=base_url()?>static/styles/fonts.css" type="text/css" />
		<link rel="stylesheet" href="<?=base_url()?>static/styles/main.css" type="text/css" media="screen" title="main" charset="utf-8" />
	
		<?php if(!empty($scripts)){?>
		<?php foreach($scripts as $script){?>
		<script src="<?php echo base_url()?>static/js/<?php echo $script?>" type="text/javascript"></script>
		<?}}?>		
	</head>
	<body>
		<div id="container">
			<div class="container">			
				<div class="header">
					<h1><a href="<?php echo base_url(); ?>" class="title"><?php echo $this->config->item('site_name');?></a></h1>
					<ul class="tabs">
						<?php $l = $this->uri->segment(1)?>
						<li><a <?php if($l == ""){ echo 'class="active"'; }?> href="<?=base_url()?>" title="Create A New Paste">Create</a></li>
						<li><a <?php if($l == "lists" || $l == "view" and $this->uri->segment(2) != "options"){ echo 'class="active"'; }?> href="<?=site_url("lists")?>" title="Recent Pastes">Recent</a></li>
						<li><a  <?php if($l == "about"){ echo 'class="active"'; }?> href="<?=site_url("about/")?>" title="About Paste.mycodenow.com">About</a></li>
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
								<?php echo($status_message); ?>
							</div>
						</div>
						<?php }?>				
