<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - index()
 * - lists()
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
