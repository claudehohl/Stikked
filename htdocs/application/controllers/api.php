<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - index()
 * - create()
 * - paste()
 * - random()
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
		echo stripslashes(json_encode($data));
	}
	
	function random() 
	{
		$this->load->model('pastes');
		$data = $this->pastes->random_paste();
		
		if (!$data) 
		{
			$data = array(
				'message' => 'Please try again',
			);
		}
		echo stripslashes(json_encode($data));
	}
}
