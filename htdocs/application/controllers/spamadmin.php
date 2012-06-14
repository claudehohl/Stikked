<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - index()
 * - lists()
 * Classes list:
 * - Main extends CI_Controller
 */

class Spamadmin extends CI_Controller
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('languages');
		
		if (!$this->db->table_exists('pid_ip')) 
		{
			$this->load->dbforge();
			$fields = array(
				'id' => array(
					'type' => 'INT',
					'constraint' => 10,
					'auto_increment' => TRUE,
				) ,
				'pid' => array(
					'type' => 'VARCHAR',
					'constraint' => 8,
				) ,
				'ip' => array(
					'type' => 'VARCHAR',
					'constraint' => 15,
				) ,
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', true);
			$this->dbforge->add_key('pid');
			$this->dbforge->add_key('ip');
			$this->dbforge->create_table('pastes', true);
		}
	}
	
	function index() 
	{
	}
	
	function lists() 
	{
		$this->load->model('pastes');
		$data = $this->pastes->getLists();
		
		if ($this->uri->segment(2) == 'rss') 
		{
			$this->load->helper('text');
			$data['page_title'] = $this->config->item('site_name');
			$data['feed_url'] = site_url('lists/rss');
			$data['replies'] = $data['pastes'];
			unset($data['pastes']);
			$this->load->view('view/rss', $data);
		}
		else
		{
			$this->load->view('list', $data);
		}
	}
}
