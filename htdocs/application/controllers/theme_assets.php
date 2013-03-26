<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - css()
 * - images()
 * - js()
 * - _expires_header()
 * Classes list:
 * - Theme_assets extends CI_Controller
 */

class Theme_assets extends CI_Controller
{
	
	function __construct() 
	{
		parent::__construct();
		$this->theme = config_item('theme');
	}
	
	function css() 
	{
		$css_file = $this->uri->segment(4);

		//file path
		$file_path = 'themes/' . $this->theme . '/css/' . $css_file;

		//fallback to default css if view in theme not found
		
		if (!file_exists($file_path)) 
		{
			$file_path = 'themes/default/css/' . $css_file;
		}

		//send
		header('Content-type: text/css');
		$this->_expires_header(1);
		readfile($file_path);
	}
	
	function images() 
	{
		$image_file = $this->uri->segment(4);

		//file path
		$file_path = 'themes/' . $this->theme . '/images/' . $image_file;

		//fallback to default css if view in theme not found
		
		if (!file_exists($file_path)) 
		{
			$file_path = 'themes/default/images/' . $image_file;
		}

		//send
		header('Content-type: ' . mime_content_type($file_path));
		$this->_expires_header(30);
		readfile($file_path);
	}
	
	function js() 
	{

		//get js
		$segments = $this->uri->segment_array();
		array_shift($segments);
		array_shift($segments);
		array_shift($segments);
		$js_file = implode('/', $segments);
		$js_file = str_replace('../', '', $js_file);

		//file path
		$file_path = 'themes/' . $this->theme . '/js/' . $js_file;

		//send
		header('Content-type: application/x-javascript');
		$this->_expires_header(30);
		readfile($file_path);
	}
	private 
	function _expires_header($days) 
	{
		header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 60 * 60 * 24 * $days));
	}
}
