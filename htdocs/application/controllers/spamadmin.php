<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - index()
 * - session()
 * Classes list:
 * - Spamadmin extends CI_Controller
 */

class Spamadmin extends CI_Controller
{
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function index() 
	{
		$this->load->model('pastes');
		$data = $this->pastes->getSpamLists();
		$this->load->view('spamlist', $data);
	}
	
	function session() 
	{
		$this->load->model('pastes');
		$session_id = 'sdf';
		$data = $this->pastes->getSpamLists($session_id);
		$this->load->view('list_sessionid', $data);
	}
}
