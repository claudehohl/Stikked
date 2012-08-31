<?php $this->load->view('defaults/header');?>
<h1><a href="<?php echo site_url('spamadmin'); ?>">Spamadmin</a> - blocked IPs</h1>

		<?php
		function checkNum($num){
			return ($num%2) ? TRUE : FALSE;
		}
		$n = 0;
		if(!empty($blocked_ips)){ ?>
			<table class="recent">
				<tbody>
					<tr>
						<th class="title">IP address</th>
						<th class="time">When</th>
						<th class="time">Spam attempts</th>
						<th class="name">Unblock IP</th>
					</tr>
		<?php foreach($blocked_ips as $ip){
				if(checkNum($n) == TRUE) {
					$eo = "even";
				} else {
					$eo = "odd";
				}
				$n++;
		?>

		<tr class="<?php echo $eo; ?>">
			<td class="first"><?php echo $ip['ip_address']; ?></td>
			<td><?php $p = explode(",", timespan($ip['blocked_at'], time())); echo $p[0]; ?> ago.</td>
			<td><?php echo '43'; ?></td>
			<td><a href="<?php echo site_url('spamadmin/blocked_ips/unblock/' . $ip['ip_address']) ?>">Unblock</a></td>
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
