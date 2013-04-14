<?php $this->load->view('defaults/header');?>
<h1><?php echo lang('paste_trending'); ?></h1>

		<?php 
		function checkNum($num){
			return ($num%2) ? TRUE : FALSE;
		}
		$n = 0;		
		if(!empty($pastes)){ ?>
			<table class="recent">
				<tbody>
					<tr>
						<th class="title"><?php echo lang('table_title'); ?></th>
						<th class="name"><?php echo lang('table_name'); ?></th>
						<th class="lang"><?php echo lang('table_lang'); ?></th>
						<th class="hits"><?php echo lang('table_hits'); ?></th>
						<th class="time"><?php echo lang('table_time'); ?></th>
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
			<td><?php echo number_format($paste['hits'], 0, '.', "'"); ?></td>
			<td><?php $p = explode(",", timespan($paste['created'], time())); echo $p[0]; ?> <?php echo lang('paste_ago'); ?>.</td>
		</tr>

		<?php }?>
				</tbody>
			</table> 
		<?php } else { ?>
			<p><?php echo lang('paste_missing'); ?> :(</p>
		<?php }?>
<?php echo $pages; ?>
<div class="spacer"></div>
<?php $this->load->view('defaults/footer');?>
