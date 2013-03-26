<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - index()
 * - view()
 * Classes list:
 * - Iphone extends CI_Controller
 */

class Iphone extends CI_Controller
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('languages');
	}
	
	function index() 
	{
		$this->load->model('pastes');
		$data = $this->pastes->getLists('iphone/');
		$this->load->view('iphone/recent', $data);
	}
	
	function view() 
	{
		$this->load->model('pastes');
		$data = $this->pastes->getPaste(3);
		$this->load->view('iphone/view', $data);
	}
}
