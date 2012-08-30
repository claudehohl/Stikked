<?php $this->load->view('defaults/header');?>
<h1><a href="<?php echo site_url('spamadmin'); ?>">Spamadmin</a> - Pastes for ip <?php echo $ip_address; ?></h1>

<div class="space">&nbsp;</div>

<div class="form_wrapper">
    <form action="" method="post">
        <label for="block_ip">Block IP 
            <span class="instruction">(<?php echo $ip_address; ?>)</span>
        </label>
        <div class="text_beside">
            <input type="checkbox" id="block_ip" name="block_ip" value="1" checked="checked" />
        </div>

        <input class="dangerbutton" type="submit" name="confirm_remove" value="Confirm removal of all pastes below" />
    </form>
</div>

<div class="space"></div>

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
