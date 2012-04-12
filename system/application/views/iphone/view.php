<?php $this->load->view('iphone/header'); ?>
<div class="info">
	<h1 class="pagetitle"><?=$title?></h1>
	<div class="meta">
		<p><strong>By</strong> <?=$name?>, <? $p = explode(',', timespan($created, time())); echo $p[0]?> ago, written in <?=$lang?>.</p>
	</div>
</div>
<div class="text_formatted">
	<?=$paste?>
</div>
<?php $this->load->view('iphone/footer'); ?>