<?php $this->load->view('iphone/header'); ?>
<div class="info">
	<h1 class="pagetitle"><?php echo $title; ?></h1>
	<div class="meta">
		<p><strong>By</strong> <?php echo $name; ?>, <?php $p = explode(',', timespan($created, time())); echo $p[0]; ?> ago, written in <?php echo $lang; ?>.</p>
	</div>
</div>
<div class="text_formatted">
	<?php echo $paste; ?>
</div>
<?php $this->load->view('iphone/footer'); ?>
