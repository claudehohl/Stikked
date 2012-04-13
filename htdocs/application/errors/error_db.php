<?php header("HTTP/1.1 404 Not Found"); 
	include("system/application/config/config.php"); 
	include("system/application/config/stikked.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Stikked</title>
				<link rel="stylesheet" href="<?php echo $config['base_url']?>static/styles/reset.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $config['base_url']?>static/styles/fonts.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $config['base_url']?>static/styles/main.css" type="text/css" media="screen" title="main" charset="utf-8" />
	</head>

	<body>
		<div id="container">
			<div class="container">
				<div class="header">
					<h1><a href="<?=$config['base_url']?>" class="title"><?php echo $config['site_name']?></a></h1>
					<div class="tabs">
						<ul>
							<li><a href="<?=$config['base_url']?>index.php">Paste</a></li>
							<li><a href="<?=$config['base_url']?>index.php/lists">Recent</a></li>
							<li><a href="<?=$config['base_url']?>index.php/about">About</a></li>
						</ul>
					</div>
				</div>
				
				<div class="page">
					<div class="content">
						<div class="container">
							<h1><?=$heading?></h1>
							<div class="about">
								<?=$message?>
								<p><a href="<?=$config['base_url']?>">Go Home</a></p>
							</div>
						</div>
					</div>
				</div>
			
			<div class="footer">
				<?php include("system/application/views/defaults/footer_message.php"); ?>
				<?php include("system/application/views/defaults/stats.php"); ?>
			</div>
			</div>
		</div>
	</body>
</html>