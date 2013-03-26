<?php $this->load->view('defaults/header');?>
	<div class="page-header">
		<h1>Trending Pastes</h1>
	</div>

		<?php
		if(!empty($pastes)){ ?>
			<table class="recent table table-striped table-bordered">
				<thead>
					<tr>
						<th class="title">Title</th>
						<th class="name">Name</th>
						<th class="lang">Language</th>
						<th class="hits">Hits</th>
						<th class="hidden">UNIX</th>
						<th class="time">When</th>
					</tr>
				</thead>
				<tbody>
		<?php	foreach($pastes as $paste) { ?>

		<tr>
			<td class="first"><a href="<?php echo site_url("view/".$paste['pid']); ?>"><?php echo $paste['title']; ?></a></td>
			<td><?php echo $paste['name']; ?></td>
			<td><?php echo $paste['lang']; ?></td>
			<td class="hidden"><?php echo $paste['created']; ?></td>
			<td><?php echo number_format($paste['hits'], 0, '.', "'"); ?></td>
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
