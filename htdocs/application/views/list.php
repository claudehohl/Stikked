<?php $this->load->view('defaults/header');?>
<small><a class="control" href="<?php echo site_url("view/options")?>">Change paste viewing options</a></small><br/><br/>
<h1>Recent Pastes <a href="<?php echo site_url('lists/rss'); ?>"><img src="<?php echo base_url(); ?>static/images/feed-icon-14x14.png" alt="rss" title="RSS" /></a></h1>

		<?php 
		function checkNum($num){
			return ($num%2) ? TRUE : FALSE;
		}
		$n = 0;		
		if(!empty($pastes)){ ?>
			<table class="recent">
				<tbody>
					<tr>
						<th class="title">Title</th>
						<th class="name">Name</th>
						<th class="lang">Language</th>
						<th class="time">When</th>
					</tr>
		<?php	foreach($pastes as $paste) {
				if(checkNum($n) == TRUE) {
					$eo = "even";
				} else {
					$eo = "odd";
				}
				$n++;
		?>	

		<tr class="<?php echo $eo; ?>">
			<td class="first"><a href="<?php echo site_url("view/".$paste['pid']); ?>"><?php echo $paste['title']; ?></a></td>
			<td><?php echo $paste['name']; ?></td>
			<td><?php echo $paste['lang']; ?></td>
			<td><?php $p = explode(",", timespan($paste['created'], time())); echo $p[0]; ?> ago.</td>
		</tr>

		<?php }?>
				</tbody>
			</table> 
		<?php } else { ?>
			<p>There have been no pastes :(</p>
		<?php }?>
<?php echo $pages; ?>
<div class="spacer"></div>
<?php $this->load->view('defaults/footer');?>
