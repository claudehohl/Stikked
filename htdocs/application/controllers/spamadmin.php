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
		$session_id = $this->uri->segment(3);
		$data = $this->pastes->getSpamLists('spamadmin/session/' . $session_id, $seg = 4, $session_id);
		$data['session_id'] = $session_id;
		$this->load->view('list_sessionid', $data);
	}
}
