<?PHP
/**
* Class and Function List:
* Function list:
* Classes list:
*/
define("upgradeMode", true);
require "upconf.php"; // Load configuration file with upgrade  settings

$status = "";

if (!$locked) 
{
	$title = "Upgrade";
	$message = " This upgrade is only needed if you migrate from version lower than 0.9.1.<br/>";
	$message.= "<span class='warning'>Warning: All custom code will be erased!</span><br/>";
	$message.= "Do you want to upgrade? <a href='{$URL}?auth={$authCode}'>Yes</a> | <a href='../'>No</a>";
}
else
{
	$title = "<span class='error'>Upgrade Locked</span>";
	$message = "Your upgrade directory is locked, unlock it by deleting \"lock\" file.";
}

if (isset($_GET['status'])) 
{
	$uStatus = preg_replace("/[^a-zA-Z0-9.\/]+/", "", $_GET['status']);
	$uSubject = ((isset($_GET['subject'])) ? preg_replace("/[^a-zA-Z0-9.\/]+/", "", $_GET['status']) : "application/config/stikked.php");
	switch ($uStatus) 
	{
	case "locked":
		$title = "<span class='error'>Upgrade Locked</span>";
		$message = "Your upgrade directory is locked, unlock it by deleting \"lock\" file.";
	break;
	case "missingTarget":
	case "missingUgs":
		$title = "<span class='error'>Upgrade Failed</span>";
		$message = "Your" . (($uStatus == "missingTarget") ? " configuration file <i>{$targetMain}</i>" : " upgrade schema file <i>{$upgradeSchema}</i>") . " is missing. Check it and try again.";
	break;
	case "lockFailed":
		$title = "<span class='error'>Security risk: Lock failed</span>";
		$message = "Locking \"upgrade\" directory failed, please, remove it manualy, otherwise, unlocked, it represents security risk.<br/>";
		$message.= "<span class='success'>However, update was successful.</span>";
	break;
	case "success":
		$title = "<span class='success'>Upgrade succeed</span>";
		$message = "You're ready to go. ";
		$message = "<< <a href='../'>Click here to go to your upgraded Stikked site.</a>";
	break;
	case "AuthFailed":
		$title = "<span class='error'>Access denied</span>";
		$message = "You cannot access {$URL} file directly.";
	break;
	case "AuthFailed-config":
		$title = "<span class='error'>Access denied</span>";
		$message = "You cannot access upconf.php file directly.";
	break;
	case "failed":
		$title = "<span class='error'>Upgrade failed</span>";
		$message = "Upgrade has failed. <br/>Your configuration <i>{$targetMain}</i> file must be writtable (chmod 777).";
	break;
	default:
	break;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Upgrade <?PHP echo $status; ?></title>

        <script type='text/javascript'>
            history.pushState(null, null, window.location.pathname);
        </script>

        <style type="text/css">

            ::selection{ background-color: #E13300; color: white; }
            ::moz-selection{ background-color: #E13300; color: white; }
            ::webkit-selection{ background-color: #E13300; color: white; }

            body {
                background-color: #fff;
                margin: 40px;
                font: 13px/20px normal Helvetica, Arial, sans-serif;
                color: #4F5155;
            }

            a {
                color: #003399;
                background-color: transparent;
                font-weight: normal;
            }

            h1 {
                color: #444;
                background-color: transparent;
                border-bottom: 1px solid #D0D0D0;
                font-size: 19px;
                font-weight: normal;
                margin: 0 0 14px 0;
                padding: 14px 15px 10px 15px;
            }

            code {
                font-family: Consolas, Monaco, Courier New, Courier, monospace;
                font-size: 12px;
                background-color: #f9f9f9;
                border: 1px solid #D0D0D0;
                color: #002166;
                display: block;
                margin: 14px 0 14px 0;
                padding: 12px 10px 12px 10px;
            }

            #container {
                margin: 10px;
                border: 1px solid #D0D0D0;
                -webkit-box-shadow: 0 0 8px #D0D0D0;
            }

            p {
                margin: 12px 15px 12px 15px;
            }

            .error {
                color: #FF0000;
            }

            .warning {
                color: orangered;
            }

            .success {
                color: green;
            }
        </style>
    </head>
    <body>
        <div id="container">
            <h1><?PHP echo $title; ?></h1>
            <?PHP echo $message; ?>
        </div>
    </body>
</html>