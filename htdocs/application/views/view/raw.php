<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title><?php echo $this->config->item('site_name'); ?></title>
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/styles/raw.css" type="text/css" media="screen" title="raw stylesheet" charset="utf-8" />
		<?php if(!empty($scripts)){ ?>
		<?php foreach($scripts as $script){ ?>
		<script src="<?php echo base_url(); ?>static/js/<?php echo $script; ?>" type="text/javascript"></script>
		<?php }} ?>
	</head>
	<body>
		<div id="container">
			<?php if(isset($insert)){
				echo $insert;
			}?>
			
			<h1><?php echo $title?></h1>
			<?php if(!$this->db_session->userdata("view_raw")){?>
				<a href="<?php echo site_url("view/".$pid)?>">Go Back</a>
			<?php } else { ?>
				<a href="<?php echo base_url()?>">Go Home</a>
			<?php }?> 
			&mdash; <a href="<?php echo site_url("view/options")?>">Change Paste Viewing Options</a>
			<pre>
<?php echo $raw?>
			</pre>
			<?php if(!$this->db_session->userdata("view_raw")){?><a href="<?php echo site_url("view/".$pid)?>">Go Back</a><?php } else { ?><a href="<?php echo base_url()?>">Go Home</a><?php }?>		
		</div>
		<?php $this->load->view('defaults/stats'); ?>
	</body>
</html>
