<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - css()
 * - images()
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
		$css_file = $this->uri->segment(4);

		//file path
		$file_path = 'themes/' . $theme . '/css/' . $css_file;

		//fallback to default css if view in theme not found
		
		if (!file_exists($file_path)) 
		{
			$file_path = 'themes/default/css/' . $css_file;
		}

		//send
		header('Content-type: text/css');
		readfile($file_path);
	}
	
	function images() 
	{
		$theme = config_item('theme');
		$image_file = $this->uri->segment(4);

		//file path
		$file_path = 'themes/' . $theme . '/images/' . $image_file;

		//fallback to default css if view in theme not found
		
		if (!file_exists($file_path)) 
		{
			$file_path = 'themes/default/images/' . $image_file;
		}

		//send
		header('Content-type: ' . mime_content_type($file_path));
		readfile($file_path);
	}
}
