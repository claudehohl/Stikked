<?php $this->load->view('iphone/header.php'); ?>
				<?php if(!empty($pastes)){
					function checkNum($num){
						return ($num%2) ? TRUE : FALSE;
					}?>
					<ul class="recent">
					<?	foreach($pastes as $paste) {
							if(checkNum($paste['id']) == TRUE) {
								$eo = "even";
							} else {
								$eo = "odd";
							}
					?>
						<li class="<?=$eo?>">
							<span class="title"><a href="<?=base_url()?>iphone/view/<?=$paste['pid']?>"><?=$paste['title']?></a></span>
							<span class="author"><?=$paste['name']?></span>
						</li>
						<? }?>
				
					
						<?=$pages?>
					</ul>
				<? } else { ?>
					<p>Sorry no pastes to show :)</p>
				<? }?>	
					
				
<?php $this->load->view('iphone/footer.php'); ?>