<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - css()
 * Classes list:
 * - Theme_assets extends CI_Controller
 */

class Theme_assets extends CI_Controller
{
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function css() 
	{
		$theme = config_item('theme');
		$css_file = $this->uri->segment(5);
		$css_file = str_replace('.css', '', $css_file);

		//file path
		$file_path = 'application/themes/' . $theme . '/css/' . $css_file . '.css';

		//fallback to default css if view in theme not found
		
		if (!file_exists($file_path)) 
		{
			$file_path = 'application/themes/default/css/' . $css_file . '.css';
		}

		//get and send
		$contents = file_get_contents($file_path);
		header('Content-type: text/css');
		echo $contents;
	}
}
