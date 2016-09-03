<?php $this->load->view('defaults/header');?>
<h1>Spamadmin</h1>
<p><?php echo $total_spam_attempts; ?> spam-pastes repelled. <a href="<?php echo site_url('spamadmin/blacklist'); ?>">View blocked IPs</a>.</p>

		<?php
		function checkNum($num){
			return ($num%2) ? TRUE : FALSE;
		}
		$n = 0;
		if(!empty($pastes)){ ?>
			<table class="recent selectable">
				<tbody>
					<tr>
						<th class="title">Title</th>
						<th class="name">Name</th>
						<th class="time">When</th>
						<th class="time">IP</th>
						<th title="Quick remove" class="hidden">X</th>
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
			<td><?php $p = explode(",", timespan($paste['created'], time())); echo $p[0]; ?> ago.</td>
			<td><a href="<?php echo site_url('spamadmin/' . $paste['ip_address']) ?>"><?php echo $paste['ip_address']; ?></a></td>
			<td class="hidden"><a class="quick_remove" title="Quickly remove all entries with this IP" data-ip="<?php echo $paste['ip_address']; ?>" href="">X</a></td>
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
