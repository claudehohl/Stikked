<?php $this->load->view('iphone/header.php'); ?>
				<?php if(!empty($pastes)){
					function checkNum($num){
						return ($num%2) ? TRUE : FALSE;
					}?>
					<ul class="recent">
					<?php	foreach($pastes as $paste) {
							if(checkNum($paste['id']) == TRUE) {
								$eo = "even";
							} else {
								$eo = "odd";
							}
					?>
						<li class="<?php echo $eo; ?>">
							<span class="title"><a href="<?php echo base_url(); ?>iphone/view/<?php echo $paste['pid']; ?>"><?php echo $paste['title']; ?></a></span>
							<span class="author"><?php echo $paste['name']; ?></span>
						</li>
						<?php }?>
				
					
						<?php echo $pages; ?>
					</ul>
				<?php } else { ?>
					<p>Sorry no pastes to show :)</p>
				<?php }?>	
					
				
<?php $this->load->view('iphone/footer.php'); ?>
