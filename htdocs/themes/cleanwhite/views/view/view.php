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

<div class="paste_info">
	<div class="info">
		<h1 class="pagetitle right"><?php echo $title; ?></h1>
		<div class="meta">
			<span class="detail by"></span>
						<?php if(isset($inreply)){?><span class="detail by"><?php echo lang('paste_isareply'); ?> <a href="<?php echo $inreply['url']?>"><?php echo $inreply['title']; ?></a> <?php echo strtolower(lang('paste_from')); ?> <?php echo $inreply['name']; ?>
			<?php if($seg3 != 'diff'){ ?>
				    - <a href="<?php echo $url . '/diff'; ?>"><?php echo lang('paste_viewdiff'); ?></a>
			<?php }else{ ?>
				    - <a href="<?php echo $url; ?>"><?php echo lang('paste_goback'); ?></a>
			<?php } ?>

			</span><?php }?>
			<div class="spacer"></div>
			By: <?=$name?> | <?php $p = explode(',', timespan($created, time())); echo sprintf($this->lang->line('paste_ago'),$p[0]); ?> | Syntax: <?=$lang?> | Views: <?php echo number_format($hits, 0, '.', "'"); ?>
			<div class="spacer"></div>
			<span class="detail"><span class="item">URL </span><a href="<?=$url?>" style="color: #858585;text-decoration: none;"><?=$url?></a></span>
			
			<?php if(!empty($snipurl)){?>
				<span class="detail"><span class="item">Snipurl </span><a href="<?=$snipurl?>" style="text-decoration: none;"><?php echo htmlspecialchars($snipurl) ?></a></span>
			<?php }?>
			
				<div class="spacer"></div>
				<br />
			</div>
		</div>
	</div>
</div>

<ul class="actions">
	<div class="container">
		<li><a href="<?=site_url("view/download/".$pid)?>"><img src="<?=site_url("themes/cleanwhite/images/download.png")?>" alt="disk" class="icon"/>Download Paste</a></li> 
		<li><a href="#reply"><img src="<?=site_url("themes/cleanwhite/images/reply.png")?>" alt="speech bubble" class="icon"/>Reply to this paste</a></li>
		<li><a href="<?=site_url("view/raw/".$pid)?>"><img src="<?=site_url("themes/cleanwhite/images/raw.png")?>" alt="blank document" class="icon"/>View Raw</a></li>
		<li><a href="<?=site_url("view/plaintext/".$pid)?>"><img src="<?=site_url("themes/cleanwhite/images/raw.png")?>" alt="blank document" class="icon"/>Plaintext</a></li>
		<li><a href="#" class="expand"><img src="<?=site_url("themes/cleanwhite/images/expand.png")?>" alt="arrows" class="icon"/>Expand paste to fill the whole browser</a></li>
	</div>
</ul>


</div>
</div>
</div>
</div>

<div class="paste">
	<div class="text_formatted">
		<div class="container">
			<?php echo $paste; ?>
		</div>
	</div>
</div>

<div class="spacer"></div>

<div class="replies">

	<div class="container">
		<?php
		
		function checkNum($num){
			return ($num%2) ? TRUE : FALSE;
		}
		
		if(isset($replies) and !empty($replies)){		
			$n = 1;
		?>
			<h1><?php echo lang('paste_replies'); ?> <?php echo $title; ?> <a href="<?php echo site_url('view/rss/' . $pid); ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAAOCAYAAAAfSC3RAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAJDSURBVHjajJJNSBRhGMd/887MzrQxRSLbFuYhoUhEKsMo8paHUKFLdBDrUIdunvq4RdClOq8Hb0FBSAVCUhFR1CGD/MrIJYqs1kLUXd382N356plZFOrUO/MMz/vO83+e93n+f+1zF+kQBoOQNLBJg0CTj7z/rvWjGbEOIwKp9O7WkhtQc/wMWrlIkP8Kc1lMS8eyFHpkpo5SgWCCVO7Z5JARhuz1Qg29fh87u6/9VWL1/SPc4Qy6n8c0FehiXin6dcCQaylDMhqGz8ydS2hKkmxNkWxowWnuBLHK6G2C8X6UJkBlxUmNqLYyNbzF74QLDrgFgh9LLE0NsPKxjW1Hz2EdPIubsOFdH2HgbwAlC4S19dT13o+3pS+vcSfvUcq9YnbwA6muW9hNpym/FWBxfh0CZkKGkPBZeJFhcWQAu6EN52QGZ/8prEKW+cdXq0039UiLXhUYzdjebOJQQI30UXp6mZn+Dtam32Afu0iyrgUvN0r+ZQbr8HncSpUVJfwRhBWC0hyGV8CxXBL5SWYf9sYBidYLIG2V87/ifVjTWAX6AlxeK2C0X8e58hOr/Qa2XJ3iLMWxB1h72tHs7bgryzHAN2o2gJorTrLxRHVazd0o4TXiyV2Yjs90uzauGvvppmqcLjwmbZ3V7BO2HOrBnbgrQRqWUgTZ5+Snx4WeKfzCCrmb3axODKNH+vvUyWjqyK4DiKQ0eXSpFsgVvLJQWpH+xSpr4otg/HI0TR/t97cxTUS+QxIMRTLi/9ZYJPI/AgwAoc3W7ZrqR2IAAAAASUVORK5CYII=" alt="rss" title="RSS" /></a></h1>
			
			<table class="recent">
				<tbody>
					<tr>
						<th class="title"><?php echo lang('table_title'); ?></th>
						<th class="name"><?php echo lang('table_name'); ?></th>
						<th class="name"><?php echo lang('table_lang'); ?></th>
						<th class="time"><?php echo lang('table_time'); ?></th>
					</tr>

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
					<td><?php $p = explode(",", timespan($reply['created'], time()));
					echo sprintf($this->lang->line('paste_ago'),$p[0]); ?>.</td>
				</tr>
		
			<?php }?>
			</tbody>
			</table>
<?php echo $pages; ?>
		<div class="spacer high"></div><div class="spacer high"></div>
		<?php }?>
		
		<?php 
			$reply_form['page']['title'] = lang('paste_replyto') . ' "' . $title . '"';
			$reply_form['page']['instructions'] = lang('paste_replyto_desc');
		$this->load->view('defaults/paste_form', $reply_form); ?>
	</div>

</div>

<?php $this->load->view('view/view_footer'); ?>
