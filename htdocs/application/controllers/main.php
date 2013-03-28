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
 * - trends()
 * - view()
 * - cron()
 * - about()
 * - captcha()
 * - _valid_lang()
 * - _valid_captcha()
 * - _valid_ip()
 * - _blockwords_check()
 * - _autofill_check()
 * - _valid_authentication()
 * - get_cm_js()
 * - error_404()
 * Classes list:
 * - Main extends CI_Controller
 */

class Main extends CI_Controller
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('languages');
		
		if ($this->config->item('require_auth')) 
		{
			$this->load->library('auth_ldap');
		}
		
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
					'constraint' => 45,
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
					'null' => TRUE,
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
					'constraint' => 50,
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
					'default' => 0,
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
				'ip_address' => array(
					'type' => 'VARCHAR',
					'constraint' => 16,
					'null' => TRUE,
				) ,
				'hits' => array(
					'type' => 'INT',
					'constraint' => 10,
					'default' => 0,
				) ,
				'hits_updated' => array(
					'type' => 'INT',
					'constraint' => 10,
					'default' => 0,
				) ,
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', true);
			$this->dbforge->add_key('pid');
			$this->dbforge->add_key('private');
			$this->dbforge->add_key('replyto');
			$this->dbforge->add_key('created');
			$this->dbforge->add_key('ip_address');
			$this->dbforge->add_key('hits');
			$this->dbforge->add_key('hits_updated');
			$this->dbforge->create_table('pastes', true);
		}
		
		if (!$this->db->table_exists('blocked_ips')) 
		{
			$this->load->dbforge();
			$fields = array(
				'ip_address' => array(
					'type' => 'VARCHAR',
					'constraint' => 16,
					'default' => 0,
				) ,
				'blocked_at' => array(
					'type' => 'INT',
					'constraint' => 10,
				) ,
				'spam_attempts' => array(
					'type' => 'INT',
					'constraint' => 6,
					'default' => 0,
				) ,
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('ip_address', true);
			$this->dbforge->create_table('blocked_ips', true);
		}
		
		if (!$this->db->table_exists('trending')) 
		{
			$this->load->dbforge();
			$fields = array(
				'paste_id' => array(
					'type' => 'VARCHAR',
					'constraint' => 8,
				) ,
				'ip_address' => array(
					'type' => 'VARCHAR',
					'constraint' => 16,
					'default' => 0,
				) ,
				'created' => array(
					'type' => 'INT',
					'constraint' => 10,
				) ,
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('paste_id', true);
			$this->dbforge->add_key('ip_address', true);
			$this->dbforge->add_key('created');
			$this->dbforge->create_table('trending', true);
		}
		
		if (!$this->db->field_exists('ip_address', 'pastes')) 
		{
			$this->load->dbforge();
			$fields = array(
				'ip_address' => array(
					'type' => 'VARCHAR',
					'constraint' => 16,
					'null' => TRUE,
				) ,
			);
			$this->dbforge->add_column('pastes', $fields);
		}
		
		if (!$this->db->field_exists('hits', 'pastes')) 
		{
			$this->load->dbforge();
			$fields = array(
				'hits' => array(
					'type' => 'INT',
					'constraint' => 10,
					'default' => 0,
				) ,
				'hits_updated' => array(
					'type' => 'INT',
					'constraint' => 10,
					'default' => 0,
				) ,
			);
			$this->dbforge->add_key('hits');
			$this->dbforge->add_key('hits_updated');
			$this->dbforge->add_column('pastes', $fields);
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
			
			if (!$this->db_session->userdata('expire')) 
			{
				$default_expiration = $this->config->item('default_expiration');
				$this->db_session->set_userdata('expire', $default_expiration);
			}
			
			if ($this->db_session->flashdata('settings_changed')) 
			{
				$data['status_message'] = 'Settings successfully changed';
			}
			$data['name_set'] = $this->db_session->userdata('name');
			$data['expire_set'] = $this->db_session->userdata('expire');
			$data['private_set'] = $this->db_session->userdata('private');
			$data['snipurl_set'] = $this->db_session->userdata('snipurl');
			$data['paste_set'] = $paste;
			$data['title_set'] = $title;
			$data['reply'] = $reply;
			
			if (!$lang) 
			{
				$lang = $this->config->item('default_language');
			}
			$data['lang_set'] = $lang;
		}
		else
		{
			$data['name_set'] = $this->input->post('name');
			$data['expire_set'] = $this->input->post('expire');
			$data['private_set'] = $this->input->post('private');
			$data['snipurl_set'] = $this->input->post('snipurl');
			$data['paste_set'] = $this->input->post('code');
			$data['title_set'] = $this->input->post('title');
			$data['reply'] = $this->input->post('reply');
			$data['lang_set'] = $this->input->post('lang');
		}
		return $data;
	}
	
	function index() 
	{
		$this->_valid_authentication();
		$this->load->helper('json');
		
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
				array(
					'field' => 'captcha',
					'label' => 'Captcha',
					'rules' => 'callback__valid_captcha',
				) ,
				array(
					'field' => 'valid_ip',
					'label' => 'Valid IP',
					'rules' => 'callback__valid_ip',
				) ,
				array(
					'field' => 'blockwords_check',
					'label' => 'No blocked words',
					'rules' => 'callback__blockwords_check',
				) ,
				array(
					'field' => 'email',
					'label' => 'Field must remain empty',
					'rules' => 'callback__autofill_check',
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
				
				if ($this->config->item('private_only')) 
				{
					$_POST['private'] = 1;
				}
				
				if ($this->input->post('reply') == false) 
				{
					$user_data = array(
						'name' => $this->input->post('name') ,
						'lang' => $this->input->post('lang') ,
						'expire' => $this->input->post('expire') ,
						'snipurl' => $this->input->post('snipurl') ,
						'private' => $this->input->post('private') ,
					);
					$this->db_session->set_userdata($user_data);
				}
				redirect($this->pastes->createPaste());
			}
		}
	}
	
	function raw() 
	{
		$this->_valid_authentication();
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
		$this->_valid_authentication();
		$this->load->model('pastes');
		$check = $this->pastes->checkPaste(3);
		
		if ($check) 
		{
			$this->load->helper('text');
			$paste = $this->pastes->getPaste(3);
			$data = $this->pastes->getReplies(3);
			$data['page_title'] = $paste['title'] . ' - ' . $this->config->item('site_name');
			$data['feed_url'] = site_url('view/rss/' . $this->uri->segment(3));
			$this->load->view('view/rss', $data);
		}
		else
		{
			show_404();
		}
	}
	
	function embed() 
	{
		$this->_valid_authentication();
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
		$this->_valid_authentication();
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
		$this->_valid_authentication();
		
		if ($this->config->item('private_only')) 
		{
			show_404();
		}
		else
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
	
	function trends() 
	{
		$this->_valid_authentication();
		
		if ($this->config->item('private_only')) 
		{
			show_404();
		}
		else
		{
			$this->load->model('pastes');
			$data = $this->pastes->getTrends();
			$this->load->view('trends', $data);
		}
	}
	
	function view() 
	{
		$this->_valid_authentication();
		$this->load->helper('json');
		$this->load->model('pastes');
		$check = $this->pastes->checkPaste(2);
		
		if ($check) 
		{
			
			if ($this->db_session->userdata('view_raw')) 
			{
				redirect('view/raw/' . $this->uri->segment(2));
			}
			$data = $this->pastes->getPaste(2, true, $this->uri->segment(3) == 'diff');
			$data['reply_form'] = $this->_form_prep($data['lang_code'], 'Re: ' . $data['title'], $data['raw'], $data['pid']);
			$this->load->view('view/view', $data);
		}
		else
		{
			show_404();
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
	
	function captcha() 
	{
		$this->load->helper('captcha');

		//get "word"
		$pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ@';
		$str = '';
		for ($i = 0;$i < 4;$i++) 
		{
			$str.= substr($pool, mt_rand(0, strlen($pool) - 1) , 1);
		}
		$word = $str;

		//save
		$this->db_session->set_userdata(array(
			'captcha' => $word
		));

		//view
		$this->load->view('view/captcha', array(
			'word' => $word
		));
	}
	
	function _valid_lang($lang) 
	{
		$this->load->model('languages');
		$this->form_validation->set_message('_valid_lang', 'Please select your language');
		return $this->languages->valid_language($lang);
	}
	
	function _valid_captcha($text) 
	{
		
		if ($this->config->item('enable_captcha')) 
		{
			$this->form_validation->set_message('_valid_captcha', 'The Captcha is incorrect.');
			return strtolower($text) == strtolower($this->db_session->userdata('captcha'));
		}
		else
		{
			return true;
		}
	}
	
	function _valid_ip() 
	{

		//get ip
		$ip_address = $this->input->ip_address();
		$ip = explode('.', $ip_address);
		$ip_firstpart = $ip[0] . '.' . $ip[1] . '.';

		//setup message
		$this->form_validation->set_message('_valid_ip', 'You are not allowed to paste.');

		//lookup
		$this->db->select('ip_address, spam_attempts');
		$this->db->like('ip_address', $ip_firstpart, 'after');
		$query = $this->db->get('blocked_ips');

		//check
		
		if ($query->num_rows() > 0) 
		{

			//update spamcount
			$blocked_ips = $query->result_array();
			$spam_attempts = $blocked_ips[0]['spam_attempts'];
			$this->db->where('ip_address', $ip_address);
			$this->db->update('blocked_ips', array(
				'spam_attempts' => $spam_attempts + 1,
			));

			//return for the validation
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function _blockwords_check() 
	{

		//setup message
		$this->form_validation->set_message('_blockwords_check', 'Your paste contains blocked words.');

		//check
		$blocked_words = $this->config->item('blocked_words');
		$post = $this->input->post();
		$raw = $post['code'];
		foreach (explode(',', $blocked_words) as $word) 
		{
			$word = trim($word);
			
			if (stristr($raw, $word)) 
			{
				return false;
			}
		}
		return true;
	}
	
	function _autofill_check() 
	{

		//setup message
		$this->form_validation->set_message('_autofill_check', 'Go away, robot!');

		//check
		return !$this->input->post('email');
	}
	
	function _valid_authentication() 
	{
		
		if ($this->config->item('require_auth')) 
		{
			
			if (!$this->auth_ldap->is_authenticated()) 
			{
				$this->db_session->set_flashdata('tried_to', "/" . $this->uri->uri_string());
				redirect('/auth');
			}
		}
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
	
	function error_404() 
	{
		show_404();
	}
}
