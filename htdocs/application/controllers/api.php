<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - index()
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
			$paste_url = $this->pastes->createPaste();
			$data['msg'] = base_url() . $paste_url;
			$this->load->view('view/api', $data);
		}
	}
}
