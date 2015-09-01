<?php
/**
 * Patch for application/config/stikked.php
 * @since 0.9.2
 * New
 *  version, new features! Your stikked.php need to be upgraded, and running this script will do so.
 * No worry, your's settings will be left intact, just few things added.
 *
 * !WARNING!
 * Any custom code will be erased. Make backup of whole installation first.
 */
define("upgradeMode", true);
require "upconf.php"; // Load configuration file with upgrade  settings


if (!isset($_GET['auth'])) 
{
	header("location: index.php?status=AuthFailed");
	exit;
}
else 
if ($_GET['auth'] !== $authCode) 
{
	header("location: index.php?status=AuthFailed");
	exit;
}

if ($locked) 
{
	header("location: index.php?status=locked");
	exit;
}
define("BASEPATH", true);

if (!file_exists($targetMain)) 
{
	header("location: index.php?status=missingTarget");
	exit;
}
else 
if (!file_exists($upgradeSchema)) 
{
	die("Your {$upgradeSchema} doesn't exist! Upgrade has failed.");
	header("location: index.php?status=missingUgs");
	exit;
}
require ($targetMain);
$upgradeSchema = file_get_contents($upgradeSchema);
/**
 * Detects type of given data and return them in appropriate string form
 * @author xZero <xzero@elite7hackers.net>
 * @param mixed $d
 * @return string result
 */

function parseOption($d) 
{
	
	if (is_bool($d)) 
	{
		return ($d) ? 'true' : 'false';
	}
	else 
	if (is_numeric($d)) 
	{
		return $d;
	}
	else 
	if (is_string($d)) 
	{
		return "'{$d}'";
	}
	else 
	if (is_array($d)) 
	{
		return var_export($d, true);
	}
	else
	{
		return "''";
	}
}
$FIND = array(
	"{INS->SITE_NAME}",
	"{INS->DB_HOSTNAME}",
	"{INS->DB_DATABASE}",
	"{INS->DB_USERNAME}",
	"{INS->DB_PASSWORD}",
	"{INS->DB_PREFIX}",
	"{INS->THEME}",
	"{INS->COMBINE_ASSETS}",
	"{INS->CRON_KEY}",
	"{INS->URL_SHORTENING_NEW#1}",
	"{INS->YOURLS_URL}",
	"{INS->YOURLS_SIGNATURE}",
	"{INS->GWGD_URL}",
	"{INS->SHORTURL_SELECTED}",
	"{INS->URL_SHORTENING_NEW#2}",
	"{INS->BACKUP_USER}",
	"{INS->BACKUP_PASS}",
	"{INS->PER_PAGE}",
	"{INS->APIKEY}",
	"{INS->PRIVATE_ONLY}",
	"{INS->ENABLE_CAPTCHA}",
	"{INS->PUBLICKEY}",
	"{INS->PRIVATEKEY}",
	"{INS->DISABLEAPI}",
	"{INS->DISABLEKEEPFOREVER}",
	"{INS->BLOCKEDWORDS}",
	"{INS->DISABLE_SHORTURL}",
	"{INS->DISALLOW_SEARCH_ENGINES}",
	"{INS->SPAMADMIN_USER}",
	"{INS->SPAMADMIN_PASS}",
	"{INS->DEFAULT_EXPIRATION}",
	"{INS->DEFAULT_LANGUAGE}",
	"{INS->UNKNOWN_POSTER}",
	"{INS->UNKNOWN_TITLE}",
	"{INS->REQUIRE_AUTH}",
	"{INS->DISPLAYURL_OVERRIDE}",
	"{INS->NOUNS}",
	"{INS->ADJECTIVES}"
);

// To protect already upgraded configs, those values are also checked, if existing.
$UPDATE = array(
	parseOption($config['site_name']) ,
	parseOption($config['db_hostname']) ,
	parseOption($config['db_database']) ,
	parseOption($config['db_username']) ,
	parseOption($config['db_password']) ,
	parseOption($config['db_prefix']) ,
	parseOption($config['theme']) ,
	parseOption($config['combine_assets']) ,
	parseOption($config['cron_key']) ,
	"\$config['url_shortening_use'] = " . (isset($config['url_shortening_use']) ? parseOption($config['url_shortening_use']) : "'off'") . ';' . PHP_EOL . "\$config['random_url_engines'] = " . ((isset($config['random_url_engines'])) ? parseOption($config['random_url_engines']) : "'googl,bitly'") . "; // Used only in random mode, read comment above for more info" . PHP_EOL,
	parseOption($config['yourls_url']) ,
	parseOption($config['yourls_signature']) ,
	parseOption($config['gwgd_url']) ,
	parseOption($config['shorturl_selected']) ,
	"// goo.gl API key" . PHP_EOL . "\$config['googl_url_api'] = " . (isset($config['googl_url_api']) ? parseOption($config['googl_url_api']) : "''") . ';' . PHP_EOL . "// Bit.ly API key" . PHP_EOL . "\$config['bitly_url_api'] = " . (isset($config['bitly_url_api']) ? parseOption($config['bitly_url_api']) : "''") . ";" . PHP_EOL,
	parseOption($config['backup_user']) ,
	parseOption($config['backup_pass']) ,
	parseOption($config['per_page']) ,
	parseOption($config['apikey']) ,
	parseOption($config['private_only']) ,
	parseOption($config['enable_captcha']) ,
	parseOption($config['recaptcha_publickey']) ,
	parseOption($config['recaptcha_privatekey']) ,
	parseOption($config['disable_api']) ,
	parseOption($config['disable_keep_forever']) ,
	parseOption($config['blocked_words']) ,
	parseOption($config['disable_shorturl']) ,
	parseOption($config['disallow_search_engines']) ,
	parseOption($config['spamadmin_user']) ,
	parseOption($config['spamadmin_pass']) ,
	parseOption($config['default_expiration']) ,
	parseOption($config['default_language']) ,
	parseOption($config['unknown_poster']) ,
	parseOption($config['unknown_title']) ,
	parseOption($config['require_auth']) ,
	parseOption($config['displayurl_override']) ,
	parseOption($config['nouns']) ,
	parseOption($config['adjectives'])
);
$tryTo = @chmod($targetMain, 0777); // Just try, if possible to evade permission errors

$tryTo = @chmod("../upgrade", 0777); // Just try, if possible to evade permission errors


if (file_put_contents($targetMain, str_replace($FIND, $UPDATE, $upgradeSchema))) 
{

	// If succesfull, lock upgrade
	$loadLock["LOCK"] = true;
	
	if (!file_put_contents("lock", serialize(array(
		"LOCK" => true
	)))) 
	{
		header("location: index.php?status=lockFailed");
		exit;
	}
	header("location: index.php?status=success");
	exit;
}
else
{
	header("location: index.php?status=failed");
	exit;
}
header("location: index.php?status=failed");
exit;
