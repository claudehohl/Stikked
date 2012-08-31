<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - index()
 * - spam_detail()
 * - blacklist()
 * - unblock_ip()
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
			$paste_count = $this->db->affected_rows();
			
			if ($this->input->post('block_ip')) 
			{
				$query = $this->db->get_where('blocked_ips', array(
					'ip_address' => $ip_address
				));
				
				if ($query->num_rows() == 0) 
				{
					$this->db->insert('blocked_ips', array(
						'ip_address' => $ip_address,
						'blocked_at' => mktime() ,
						'spam_attempts' => $paste_count,
					));
				}
			}
		}

		//fill data
		$data = $this->pastes->getSpamLists('spamadmin/' . $ip_address, $seg = 3, $ip_address);
		$data['ip_address'] = $ip_address;
		$ip = explode('.', $ip_address);
		$ip_firstpart = $ip[0] . '.' . $ip[1] . '.';
		$data['ip_range'] = $ip_firstpart . '*.*';

		//view
		$this->load->view('spam_detail', $data);
	}
	
	function blacklist() 
	{
		$this->db->select('ip_address, blocked_at, spam_attempts');
		$this->db->order_by('blocked_at desc, ip_address asc');
		$query = $this->db->get('blocked_ips');
		$data['blocked_ips'] = $query->result_array();

		//view
		$this->load->view('list_blocked_ips', $data);
	}
	
	function unblock_ip() 
	{
		$ip_address = $this->uri->segment(4);
		$this->db->where('ip_address', $ip_address);
		$this->db->delete('blocked_ips');
		redirect('spamadmin/blacklist');
	}
}
