<?php
/**
* Class and Function List:
* Function list:
* Classes list:
*/

if (!defined("upgradeMode")) 
{
	header("location: index.php?status=AuthFailed");
	exit;
}
$URL = "upgrade.php";
$targetMain = "../application/config/stikked.php";
$upgradeSchema = "upgrade_schema.ugs";
$authCode = "e4434b336503842424d7ffd0628d36f88e2270fbe9c6a7bc46cf5e3510bfd8d5";

// Lock check

if (!file_exists("lock")) 
{
	$locked = false;
}
else
{
	$locked = true;
}
