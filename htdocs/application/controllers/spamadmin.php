<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - index()
 * - spam_detail()
 * Classes list:
 * - Spamadmin extends CI_Controller
 */

class Spamadmin extends CI_Controller
{
	
	function __construct() 
	{
		parent::__construct();

		//protection
		$user = $this->config->item('spamadmin_user');
		$pass = $this->config->item('spamadmin_pass');
		
		if ($user == '' || $pass == '' || !isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] != $user || $_SERVER['PHP_AUTH_PW'] != $pass) 
		{
			header('WWW-Authenticate: Basic realm="Spamadmin"');
			header('HTTP/1.0 401 Unauthorized');
			exit;
		}
	}
	
	function index() 
	{
		$this->load->model('pastes');
		$data = $this->pastes->getSpamLists();
		$this->load->view('list_ips', $data);
	}
	
	function spam_detail() 
	{
		$this->load->model('pastes');
		$ip_address = $this->uri->segment(2);
		
		if ($this->input->post('confirm_remove') && $ip_address != '') 
		{
			$this->db->where('ip_address', $ip_address);
			$this->db->delete('pastes');

			//todo: catch duplicate error
			
			if ($this->input->post('block_ip')) 
			{
				$this->db->insert('blocked_ips', array(
					'ip_address' => $ip_address
				));
			}
		}

		//fill data
		$data = $this->pastes->getSpamLists('spamadmin/' . $ip_address, $seg = 3, $ip_address);
		$data['ip_address'] = $ip_address;

		//view
		$this->load->view('spam_detail', $data);
	}
}
