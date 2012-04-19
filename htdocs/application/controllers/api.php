<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - create()
 * Classes list:
 * - Api extends Main
 */
include_once ('application/controllers/main.php');

class Api extends Main
{
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function create() 
	{
		$this->load->model('pastes');
		
		if (!$this->input->post('text')) 
		{
			echo 'missing paste text';
		}
		else
		{
			echo $this->pastes->createPaste();
		}
	}
}
