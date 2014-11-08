<?php $this->load->view('defaults/header');

$seg3 = $this->uri->segment(3);

if($seg3 != 'diff'){
    $page_url = $url;
}else{
    $page_url = $url . '/diff';
}

if(isset($insert)){
	echo $insert;
}?>

<section>
	<div class="row">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="page-header">
				<h1 class="pagetitle right"><?php echo $title; ?></h1>
			</div>
			<div class="row">
				<div class="col-8 col-sm-12 col-lg-8">
					<div class="detail by"><?php echo lang('paste_from'); ?> <?php echo $name; ?>, <?php $p = explode(',', timespan($created, time())); echo $p[0]?> <?php echo lang('paste_ago'); ?>, <?php echo lang('paste_writtenin'); ?> <?php echo $lang; ?>.</div>
					<?php if(isset($inreply)){?><div class="detail by"><?php echo lang('paste_isareply'); ?> <a href="<?php echo $inreply['url']?>"><?php echo $inreply['title']; ?></a> <?php echo strtolower(lang('paste_from')); ?> <?php echo $inreply['name']; ?>

<?php if($seg3 != 'diff'){ ?>
            - <a href="<?php echo $url . '/diff'; ?>"><?php echo lang('paste_viewdiff'); ?></a>
<?php }else{ ?>
            - <a href="<?php echo $url; ?>"><?php echo lang('paste_goback'); ?></a>
<?php } ?>

</div><?php }?>
					<div class="detail"><span class="item"><?php echo lang('paste_url'); ?> </span><a href="<?php echo $url; ?>"><?php echo $url; ?></a></div>
					<?php if(!empty($snipurl)){?>
						<div class="detail"><div class="item"><?php echo lang('paste_shorturl');?> </div><a href="<?php echo $snipurl; ?>"><?php echo htmlspecialchars($snipurl) ?></a></div>
					<?php }?>
					<div class="detail"><span class="item"><?php echo lang('paste_embed'); ?> </span><input data-lang-showcode="<?php echo lang('paste_showcode'); ?>" id="embed_field" type="text" value="<?php echo htmlspecialchars('<iframe src="' . site_url('view/embed/' . $pid) . '" style="border:none;width:100%"></iframe>'); ?>" /></div>

					<div class="detail">
<?php if($seg3 != 'diff'){ ?>
                    <a class="control" href="<?php echo site_url("view/download/".$pid); ?>"><?php echo lang('paste_download'); ?></a> <?php echo lang('paste_or'); ?> <a class="control" href="<?php echo site_url("view/raw/".$pid); ?>"><?php echo lang('paste_viewraw'); ?></a></div>
<?php }else{ ?>
                    <?php echo lang('paste_viewdiffs'); ?> <a href="<?php echo $inreply['url']?>"><?php echo $inreply['title']; ?></a> <?php echo lang('paste_and'); ?> <a href="<?php echo $url; ?>"><?php echo $title; ?></a>
<?php } ?>
				</div>
				<div class="col-4 col-sm-12 col-lg-4">
					<img src="<?php echo site_url('static/qr/' . $pid ); ?>">
				</div>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="row">
		<div class="col-12 col-sm-12 col-lg-12">
			<blockquote class="CodeMirror"><?php echo $paste; ?></blockquote>
		</div>
	</div>
</section>
<section>
<?php

function checkNum($num){
	return ($num%2) ? TRUE : FALSE;
}

if(isset($replies) and !empty($replies)){
	$n = 1;
?>
	<h1><?php echo lang('paste_replies'); ?> <?php echo $title; ?> <a href="<?php echo site_url('view/rss/' . $pid); ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAAOCAYAAAAfSC3RAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAJDSURBVHjajJJNSBRhGMd/887MzrQxRSLbFuYhoUhEKsMo8paHUKFLdBDrUIdunvq4RdClOq8Hb0FBSAVCUhFR1CGD/MrIJYqs1kLUXd382N356plZFOrUO/MMz/vO83+e93n+f+1zF+kQBoOQNLBJg0CTj7z/rvWjGbEOIwKp9O7WkhtQc/wMWrlIkP8Kc1lMS8eyFHpkpo5SgWCCVO7Z5JARhuz1Qg29fh87u6/9VWL1/SPc4Qy6n8c0FehiXin6dcCQaylDMhqGz8ydS2hKkmxNkWxowWnuBLHK6G2C8X6UJkBlxUmNqLYyNbzF74QLDrgFgh9LLE0NsPKxjW1Hz2EdPIubsOFdH2HgbwAlC4S19dT13o+3pS+vcSfvUcq9YnbwA6muW9hNpym/FWBxfh0CZkKGkPBZeJFhcWQAu6EN52QGZ/8prEKW+cdXq0039UiLXhUYzdjebOJQQI30UXp6mZn+Dtam32Afu0iyrgUvN0r+ZQbr8HncSpUVJfwRhBWC0hyGV8CxXBL5SWYf9sYBidYLIG2V87/ifVjTWAX6AlxeK2C0X8e58hOr/Qa2XJ3iLMWxB1h72tHs7bgryzHAN2o2gJorTrLxRHVazd0o4TXiyV2Yjs90uzauGvvppmqcLjwmbZ3V7BO2HOrBnbgrQRqWUgTZ5+Snx4WeKfzCCrmb3axODKNH+vvUyWjqyK4DiKQ0eXSpFsgVvLJQWpH+xSpr4otg/HI0TR/t97cxTUS+QxIMRTLi/9ZYJPI/AgwAoc3W7ZrqR2IAAAAASUVORK5CYII=" alt="rss" title="RSS" /></a></h1>

	<table class="recent table table-striped table-bordered">
		<thead>
			<tr>
				<th class="title"><?php echo lang('table_title'); ?></th>
				<th class="name"><?php echo lang('table_name'); ?></th>
				<th class="lang"><?php echo lang('table_lang'); ?></th>
				<th class="hidden">UNIX</th>
				<th class="time"><?php echo lang('table_time'); ?></th>
			</tr>
		</thead>
		<tbody>
	<?php foreach($replies as $reply){
			if(checkNum($n)){
				$eo = "even";
			} else {
				$eo = "odd";
			}
			$n++;
	?>

		<tr class="<?php echo $eo; ?>">
			<td class="first"><a href="<?php echo site_url("view/".$reply['pid']); ?>"><?php echo $reply['title']; ?></a></td>
			<td><?php echo $reply['name']; ?></td>
			<td><?php echo $reply['lang']; ?></td>
			<td class="hidden"><?php echo $reply['created']; ?></td>
			<td><?php $p = explode(",", timespan($reply['created'], time())); echo $p[0];?> <?php echo lang('paste_ago'); ?>.</td>
		</tr>

	<?php }?>
	</tbody>
	</table>
</section>
<?php echo $pages;
}

	$reply_form['page']['title'] = lang('paste_replyto') . ' "' . $title . '"';
	$reply_form['page']['instructions'] = lang('paste_replyto_desc');
	$this->load->view('defaults/paste_form', $reply_form); ?>


<?php $this->load->view('view/view_footer'); ?>
