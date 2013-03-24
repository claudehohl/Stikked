<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - theme()
 * - view()
 * Classes list:
 * - MY_Loader extends CI_Loader
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Loader extends CI_Loader
{
	var $template = '';
	var $data = array();
	var $return = FALSE;
	
	function __construct() 
	{
		parent::__construct();
		log_message('debug', 'MY_Loader Class Initialized');
	}
	
	function theme($template = '', $data = array() , $return = FALSE) 
	{
		
		if ($template == '') 
		{
			return FALSE;
		}
		$this->template = $template;
		$this->data = $this->_ci_object_to_array($data);
		$this->return = $return;
	}
	
	function view($view, $vars = array() , $return = FALSE) 
	{
		log_message('debug', 'Using view "themes/' . $this->template . '/views/' . $view . '.php"');
		return $this->_ci_load(array(
			'_ci_view' => '../themes/' . $this->template . '/views/' . $view . '.php',
			'_ci_vars' => $this->_ci_object_to_array($vars) ,
			'_ci_return' => $return
		));
	}
}
