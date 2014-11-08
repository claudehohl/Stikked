<?php
/**
 * Class and Function List:
 * Function list:
 * Classes list:
 */
require_once ('./application/libraries/phpqrcode/qrlib.php');
$qrurl = $url;

if ($snipurl != false) 
{
	$qrurl = $snipurl;
}
QRcode::png($qrurl);
