<?php $this->load->view('defaults/header'); ?>

<?php if(isset($insert)){
	echo $insert;
}?>

<div class="paste_info">
	<div class="info">
		<h1 class="pagetitle right"><?php echo $title; ?></h1>
		<div class="meta">
			<span class="detail by">By <?php echo $name; ?>, <?php $p = explode(',', timespan($created, time())); echo $p[0]?> ago, written in <?php echo $lang; ?>.</span>
			<?php if(isset($inreply)){?><span class="detail by">This paste is a reply to <a href="<?php echo $inreply['url']?>"><?php echo $inreply['title']; ?></a> by <?php echo $inreply['name']; ?></span><?php }?>
			<div class="spacer"></div>
			<span class="detail"><span class="item">URL </span><a href="<?php echo $url; ?>"><?php echo $url; ?></a></span>
			<?php if(!empty($snipurl)){?>
				<span class="detail"><span class="item">Shorturl </span><a href="<?php echo $snipurl; ?>"><?php echo htmlspecialchars($snipurl) ?></a></span>
			<?php }?>
			<span class="detail"><span class="item">Embed </span><input id="embed_field" type="text" value="<?php echo htmlspecialchars('<iframe src="' . site_url('view/embed/' . $pid) . '" style="border:none;width:100%"></iframe>'); ?>" /></span>
			<div class="spacer"></div>
			
			<span class="detail"><a class="control" href="<?php echo site_url("view/download/".$pid); ?>">Download Paste</a> or <a class="control" href="<?php echo site_url("view/raw/".$pid); ?>">View Raw</a> &mdash; <a href="#" class="expand control">Expand paste</a> to full width of browser | <a href="<?php echo site_url('view/options'); ?>">Change Viewing Options</a></span>
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>

<div class="paste <?php if($full_width){ echo "full"; }?>">
	<div class="text_formatted <?php if($full_width){ echo "full"; }?>">
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
			<h1>Replies to <?php echo $title; ?> <a href="<?php echo site_url('view/rss/' . $pid); ?>"><img src="<?php echo base_url(); ?>static/images/feed-icon-14x14.png" alt="rss" title="RSS" /></a></h1>
			
			<table class="recent">
				<tbody>
					<tr>
						<th class="title">Title</th>
						<th class="name">Name</th>
						<th class="time">When</th>
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
					<td><?php $p = explode(",", timespan($reply['created'], time())); echo $p[0];?> ago.</td>
				</tr>
		
			<?php }?>
			</tbody>
			</table>
<?php echo $pages; ?>
		<div class="spacer high"></div><div class="spacer high"></div>
		<?php }?>
		
		<?php 
			$reply_form['page']['title'] = "Reply to \"$title\"";
			$reply_form['page']['instructions'] = 'Here you can reply to the paste above';
		$this->load->view('defaults/paste_form', $reply_form); ?>
	</div>

</div>

<?php $this->load->view('view/view_footer'); ?>
