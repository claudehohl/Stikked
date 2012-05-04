<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - _form_prep()
 * - index()
 * - raw()
 * - rss()
 * - embed()
 * - download()
 * - lists()
 * - view()
 * - _view_options_prep()
 * - view_options()
 * - cron()
 * - about()
 * - _valid_lang()
 * - get_cm_js()
 * Classes list:
 * - Main extends CI_Controller
 */

class Main extends CI_Controller
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('languages');
		
		if (!$this->db->table_exists('ci_sessions')) 
		{
			$this->load->dbforge();
			$fields = array(
				'session_id' => array(
					'type' => 'VARCHAR',
					'constraint' => 40,
					'default' => 0,
				) ,
				'ip_address' => array(
					'type' => 'VARCHAR',
					'constraint' => 16,
					'default' => 0,
				) ,
				'user_agent' => array(
					'type' => 'VARCHAR',
					'constraint' => 50,
				) ,
				'last_activity' => array(
					'type' => 'INT',
					'constraint' => 10,
					'unsigned' => TRUE,
					'default' => 0,
				) ,
				'session_data' => array(
					'type' => 'TEXT',
				) ,
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('session_id', true);
			$this->dbforge->create_table('ci_sessions', true);
		}
		
		if (!$this->db->table_exists('pastes')) 
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
				'title' => array(
					'type' => 'VARCHAR',
					'constraint' => 32,
				) ,
				'name' => array(
					'type' => 'VARCHAR',
					'constraint' => 32,
				) ,
				'lang' => array(
					'type' => 'VARCHAR',
					'constraint' => 32,
				) ,
				'private' => array(
					'type' => 'TINYINT',
					'constraint' => 1,
				) ,
				'paste' => array(
					'type' => 'LONGTEXT',
				) ,
				'raw' => array(
					'type' => 'LONGTEXT',
				) ,
				'created' => array(
					'type' => 'INT',
					'constraint' => 10,
				) ,
				'expire' => array(
					'type' => 'INT',
					'constraint' => 10,
					'default' => 0,
				) ,
				'toexpire' => array(
					'type' => 'TINYINT',
					'constraint' => 1,
					'unsigned' => TRUE,
				) ,
				'snipurl' => array(
					'type' => 'VARCHAR',
					'constraint' => 64,
					'default' => 0,
				) ,
				'replyto' => array(
					'type' => 'VARCHAR',
					'constraint' => 8,
				) ,
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', true);
			$this->dbforge->add_key('pid');
			$this->dbforge->add_key('private');
			$this->dbforge->add_key('replyto');
			$this->dbforge->add_key('created');
			$this->dbforge->create_table('pastes', true);
		}
	}
	
	function _form_prep($lang = false, $title = '', $paste = '', $reply = false) 
	{
		$this->load->model('languages');
		$this->load->helper('form');
		$data['languages'] = $this->languages->get_languages();

		//codemirror languages
		$this->load->config('codemirror_languages');
		$codemirror_languages = $this->config->item('codemirror_languages');
		$data['codemirror_languages'] = $codemirror_languages;

		//codemirror modes
		$cmm = array();
		foreach ($codemirror_languages as $geshi_name => $l) 
		{
			
			if (gettype($l) == 'array') 
			{
				$cmm[$geshi_name] = $l['mode'];
			}
		}
		$data['codemirror_modes'] = $cmm;
		
		if (!$this->input->post('submit')) 
		{
			
			if ($this->db_session->flashdata('settings_changed')) 
			{
				$data['status_message'] = 'Settings successfully changed';
			}
			$data['name_set'] = $this->db_session->userdata('name');
			$data['expire_set'] = $this->db_session->userdata('expire');
			$data['acopy_set'] = $this->db_session->userdata('acopy');
			$data['private_set'] = $this->db_session->userdata('private');
			$data['snipurl_set'] = $this->db_session->userdata('snipurl');
			$data['remember_set'] = $this->db_session->userdata('remember');
			$data['paste_set'] = $paste;
			$data['title_set'] = $title;
			$data['reply'] = $reply;
			
			if (!$lang) 
			{
				$lang = $this->config->item('default_language');
			}
			
			if ($this->db_session->userdata('lang') == false) 
			{
				$data['lang_set'] = $lang;
			}
			elseif ($this->db_session->userdata('lang')) 
			{
				$data['lang_set'] = $this->db_session->userdata('lang');
			}
		}
		else
		{
			$data['name_set'] = $this->input->post('name');
			$data['expire_set'] = $this->input->post('expire');
			$data['acopy_set'] = $this->input->post('acopy');
			$data['private_set'] = $this->input->post('private');
			$data['snipurl_set'] = $this->input->post('snipurl');
			$data['remember_set'] = $this->input->post('remember');
			$data['paste_set'] = $this->input->post('paste');
			$data['title_set'] = $this->input->post('title');
			$data['reply'] = $this->input->post('reply');
			$data['lang_set'] = $this->input->post('lang');
		}
		return $data;
	}
	
	function index() 
	{
		
		if (!$this->input->post('submit')) 
		{
			$data = $this->_form_prep();
			$this->load->view('home', $data);
		}
		else
		{
			$this->load->model('pastes');
			$this->load->library('form_validation');

			//rules
			$rules = array(
				array(
					'field' => 'code',
					'label' => 'Main Paste',
					'rules' => 'required',
				) ,
				array(
					'field' => 'lang',
					'label' => 'Language',
					'rules' => 'min_length[1]|required|callback__valid_lang',
				) ,
			);

			//form validation
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_message('min_length', 'The %s field can not be empty');
			$this->form_validation->set_error_delimiters('<div class="message error"><div class="container">', '</div></div>');
			
			if ($this->form_validation->run() == FALSE) 
			{
				$data = $this->_form_prep();
				$this->load->view('home', $data);
			}
			else
			{
				
				if ($this->input->post('acopy')) 
				{
					$this->db_session->set_flashdata('acopy', 'true');
				}
				
				if ($this->input->post('remember') and $this->input->post('reply') == false) 
				{
					$user_data = array(
						'name' => $this->input->post('name') ,
						'lang' => $this->input->post('lang') ,
						'expire' => $this->input->post('expire') ,
						'acopy' => $this->input->post('acopy') ,
						'snipurl' => $this->input->post('snipurl') ,
						'private' => $this->input->post('private') ,
						'remember' => $this->input->post('remember')
					);
					$this->db_session->set_userdata($user_data);
				}
				
				if ($this->input->post('remember') == false and $this->db_session->userdata("remember") == 1) 
				{
					$user_data = array(
						'name' => '',
						'lang' => 'php',
						'expire' => '0',
						'acopy' => '0',
						'snipurl' => '0',
						'private' => '0',
						'remember' => '0'
					);
					$this->db_session->unset_userdata($user_data);
				}
				redirect($this->pastes->createPaste());
			}
		}
	}
	
	function raw() 
	{
		$this->load->model('pastes');
		$check = $this->pastes->checkPaste(3);
		
		if ($check) 
		{
			$data = $this->pastes->getPaste(3);
			$this->load->view('view/raw', $data);
		}
		else
		{
			show_404();
		}
	}
	
	function rss() 
	{
		$this->load->model('pastes');
		$check = $this->pastes->checkPaste(3);
		
		if ($check) 
		{
			$data = $this->pastes->getReplies(3);
			$data['feed_url'] = '';
			$data['page_description'] = '';
			$data['page_language'] = '';
			$data['creator_email'] = '';
			$this->load->view('view/rss', $data);
		}
		else
		{
			show_404();
		}
	}
	
	function embed() 
	{
		$this->load->model('pastes');
		$check = $this->pastes->checkPaste(3);
		
		if ($check) 
		{
			$data = $this->pastes->getPaste(3);
			$this->load->view('view/embed', $data);
		}
		else
		{
			show_404();
		}
	}
	
	function download() 
	{
		$this->load->model('pastes');
		$check = $this->pastes->checkPaste(3);
		
		if ($check) 
		{
			$data = $this->pastes->getPaste(3);
			$this->load->view('view/download', $data);
		}
		else
		{
			show_404();
		}
	}
	
	function lists() 
	{
		$this->load->model('pastes');
		$data = $this->pastes->getLists();
		$this->load->view('list', $data);
	}
	
	function view() 
	{
		$this->load->model('pastes');
		$check = $this->pastes->checkPaste(2);
		
		if ($check) 
		{
			
			if ($this->db_session->userdata('view_raw')) 
			{
				$this->db_session->keep_flashdata('acopy');
				redirect('view/raw/' . $this->uri->segment(2));
			}
			$data = $this->pastes->getPaste(2, true);
			$data['reply_form'] = $this->_form_prep($data['lang_code'], 'Re: ' . $data['title'], $data['raw'], $data['pid']);
			
			if ($this->db_session->userdata('full_width')) 
			{
				$data['full_width'] = true;
			}
			else
			{
				$data['full_width'] = false;
			}
			$this->load->view('view/view', $data);
		}
		else
		{
			show_404();
		}
	}
	
	function _view_options_prep() 
	{
		$this->load->helper('form');
		
		if ($this->db_session->userdata('remember_view') > 0) 
		{
			$data['full_width_set'] = $this->db_session->userdata('full_width');
			$data['view_raw_set'] = $this->db_session->userdata('view_raw');
		}
		else
		{
			$data['full_width_set'] = false;
			$data['view_raw_set'] = false;
		}
		return $data;
	}
	
	function view_options() 
	{
		
		if (!$this->input->post('submit')) 
		{
			$data = $this->_view_options_prep();
			$this->load->view('view/view_options', $data);
		}
		else
		{
			$this->load->library('form_validation');
			$rules = array(
				array(
					'field' => 'full_width',
					'label' => 'full_width',
					'rules' => 'max_length[1]',
				) ,
				array(
					'field' => 'view_raw',
					'label' => 'view_raw',
					'rules' => 'max_length[1]',
				) ,
			);
			$this->form_validation->set_rules($rules);
			
			if ($this->form_validation->run() == false) 
			{
				exit('Ugh, stupid skiddie.');
			}
			else
			{
				$user_data = array(
					'full_width' => $this->input->post('full_width') ,
					'view_raw' => $this->input->post('view_raw') ,
					'remember_view' => true
				);
				$this->db_session->set_userdata($user_data);
				$this->db_session->set_flashdata('settings_changed', 'true');
				redirect();
			}
		}
	}
	
	function cron() 
	{
		$this->load->model('pastes');
		$key = $this->uri->segment(2);
		
		if ($key != $this->config->item('cron_key')) 
		{
			show_404();
		}
		else
		{
			$this->pastes->cron();
			return 0;
		}
	}
	
	function about() 
	{
		$this->load->view('about');
	}
	
	function _valid_lang($lang) 
	{
		$this->load->model('languages');
		$this->form_validation->set_message('_valid_lang', 'Please select your language');
		return $this->languages->valid_language($lang);
	}
	
	function get_cm_js() 
	{
		$lang = $this->uri->segment(3);
		$this->load->config('codemirror_languages');
		$cml = $this->config->item('codemirror_languages');
		
		if (isset($cml[$lang]) && gettype($cml[$lang]) == 'array') 
		{
			header('Content-Type: application/x-javascript; charset=utf-8');
			foreach ($cml[$lang]['js'] as $js) 
			{
				echo file_get_contents('./static/js/' . $js[0]);
			}
		}
		exit;
	}
}
