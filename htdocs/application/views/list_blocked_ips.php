<?php $this->load->view('defaults/header');?>
<h1><a href="<?php echo site_url('spamadmin'); ?>">Spamadmin</a> - blocked IP ranges</h1>

		<?php
		function checkNum($num){
			return ($num%2) ? TRUE : FALSE;
		}
		$n = 0;
		if(!empty($blocked_ips)){ ?>
			<table class="recent">
				<tbody>
					<tr>
						<th class="title">IP range</th>
						<th class="time">When</th>
						<th class="time">Spam attempts</th>
						<th class="name">Unblock IP</th>
					</tr>
		<?php foreach($blocked_ips as $ip_address){
				if(checkNum($n) == TRUE) {
					$eo = "even";
				} else {
					$eo = "odd";
				}
				$n++;
                $ip = explode('.', $ip_address['ip_address']);
                $ip_firstpart = $ip[0] . '.' . $ip[1] . '.';
                $ip_range = $ip_firstpart . '*.*';
		?>

		<tr class="<?php echo $eo; ?>">
			<td class="first"><?php echo $ip_range; ?></td>
			<td><?php $p = explode(",", timespan($ip_address['blocked_at'], time())); echo $p[0]; ?> ago.</td>
			<td><?php echo $ip_address['spam_attempts']; ?></td>
			<td><a href="<?php echo site_url('spamadmin/blacklist/unblock/' . $ip_address['ip_address']) ?>">Unblock</a></td>
		</tr>

		<?php }?>
				</tbody>
			</table>
		<?php } else { ?>
			<p>No IP ranges blocked.</p>
		<?php }?>
<?php echo $pages; ?>
<div class="spacer"></div>
<?php $this->load->view('defaults/footer');?>
