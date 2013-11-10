<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - index()
 * - create()
 * - paste()
 * - random()
 * - recent()
 * - trending()
 * Classes list:
 * - Api extends Main
 */
include_once ('application/controllers/main.php');

class Api extends Main
{
	
	function __construct() 
	{
		parent::__construct();
		
		if (config_item('disable_api')) 
		{
			die("The API has been disabled\n");
		}
	}
	
	function index() 
	{
		$languages = $this->languages->get_languages();
		$languages = array_keys($languages);
		$languages = implode(', ', $languages);
		$data['languages'] = $languages;
		$this->load->view('api_help', $data);
	}
	
	function create() 
	{
		$this->load->model('pastes');
		$this->load->library('form_validation'); //needed by parent class

		
		if (!$this->input->post('text')) 
		{
			$data['msg'] = 'Error: Missing paste text';
			$this->load->view('view/api', $data);
		}
		else
		{
			
			if (!$this->input->post('lang')) 
			{
				$_POST['lang'] = 'text';
			}
			$_POST['code'] = $this->input->post('text');
			
			if ($this->config->item('private_only')) 
			{
				$_POST['private'] = 1;
			}

			//validations
			
			if (!$this->_valid_ip()) 
			{
				die("You are not allowed to paste\n");
			}
			
			if (!$this->_blockwords_check()) 
			{
				die("Your paste contains blocked words\n");
			}

			//create paste
			$paste_url = $this->pastes->createPaste();
			$data['msg'] = base_url() . $paste_url;
			$this->load->view('view/api', $data);
		}
	}
	
	function paste() 
	{
		$this->load->model('pastes');
		$check = $this->pastes->checkPaste(3);
		
		if ($check) 
		{
			$data = $this->pastes->getPaste(3);
		}
		else
		{
			$data = array(
				'message' => 'Not found',
			);
		}
		echo json_encode($data);
	}
	
	function random() 
	{
		$this->load->model('pastes');
		$data = $this->pastes->random_paste();
		echo json_encode($data);
	}
	
	function recent() 
	{
		$this->load->model('pastes');
		$pastes = $this->pastes->getLists();
		$pastes = $pastes['pastes'];
		$data = array();
		foreach ($pastes as $paste) 
		{
			$data[] = array(
				'pid' => $paste['pid'],
				'title' => $paste['title'],
				'name' => $paste['name'],
				'created' => $paste['created'],
				'lang' => $paste['lang'],
			);
		}
		echo json_encode($data);
	}
	
	function trending() 
	{
		$this->load->model('pastes');
		$pastes = $this->pastes->getTrends();
		$pastes = $pastes['pastes'];
		$data = array();
		foreach ($pastes as $paste) 
		{
			$data[] = array(
				'pid' => $paste['pid'],
				'title' => $paste['title'],
				'name' => $paste['name'],
				'created' => $paste['created'],
				'lang' => $paste['lang'],
				'hits' => $paste['hits'],
			);
		}
		echo json_encode($data);
	}
}
