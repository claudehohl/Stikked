<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - view()
 * Classes list:
 * - MY_Loader extends CI_Loader
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Loader extends CI_Loader
{
	
	function __construct() 
	{
		parent::__construct();
		log_message('debug', 'MY_Loader Class Initialized');
	}
	
	function view($view, $vars = array() , $return = FALSE) 
	{

		//theme name
		$theme = config_item('theme');

		//view path
		$view_path = 'themes/' . $theme . '/views/' . $view . '.php';

		//fallback to default view if view in theme not found
		
		if (!file_exists('application/' . $view_path)) 
		{
			$view_path = 'themes/default/views/' . $view . '.php';
		}

		//return
		return $this->_ci_load(array(
			'_ci_view' => '../' . $view_path,
			'_ci_vars' => $this->_ci_object_to_array($vars) ,
			'_ci_return' => $return
		));
	}
}
