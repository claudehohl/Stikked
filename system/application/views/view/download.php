<?php 

header('Content-disposition: attachment');
echo html_entity_decode($raw); 

?>