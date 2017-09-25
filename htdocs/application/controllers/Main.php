<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - _form_prep()
 * - index()
 * - post_encrypted()
 * - raw()
 * - rss()
 * - embed()
 * - qr()
 * - download()
 * - lists()
 * - trends()
 * - view()
 * - cron()
 * - about()
 * - captcha()
 * - _valid_lang()
 * - _valid_captcha()
 * - _valid_recaptcha()
 * - _valid_ip()
 * - _valid_ipv4()
 * - _valid_ipv6()
 * - _blockwords_check()
 * - _autofill_check()
 * - _valid_authentication()
 * - get_cm_js()
 * - error_404()
 * - robots_txt()
 * Classes list:
 * - Main extends CI_Controller
 */

class Main extends CI_Controller
{
	
	function __construct() 
	{
		parent::__construct();
		$this->output->enable_profiler(false);
		$this->load->model('languages');
		$this->load->library('curl');
		
		if (config_item('require_auth')) 
		{
			$this->load->library('auth_ldap');
		}

		//recaptcha
		$this->recaptcha_publickey = config_item('recaptcha_publickey');
		$this->recaptcha_privatekey = config_item('recaptcha_privatekey');
		$this->use_recaptcha = false;
		
		if ($this->recaptcha_publickey != '' && $this->recaptcha_privatekey != '') 
		{
			$this->load->helper('recaptcha');
			$this->use_recaptcha = true;
		}
		
		if (!$this->db->table_exists('sessions')) 
		{
			$this->load->dbforge();
			
			if ($this->db->table_exists('ci_sessions')) 
			{
				$this->dbforge->drop_table('ci_sessions');
			}
			$fields = array(
				'id' => array(
					'type' => 'VARCHAR',
					'constraint' => 40,
					'default' => 0,
				) ,
				'ip_address' => array(
					'type' => 'VARCHAR',
					'constraint' => 45,
					'default' => 0,
				) ,
				'timestamp' => array(
					'type' => 'INT',
					'constraint' => 10,
					'unsigned' => TRUE,
					'default' => 0,
				) ,
				'data' => array(
					'type' => ($this->db->dbdriver == "postgre") ? 'TEXT' : 'BLOB',
				) ,
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', true);
			$this->dbforge->add_key('timestamp');
			$this->dbforge->create_table('sessions', true);
		}

		// load this after db has been initialized
		$this->load->library('session');
		
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
					'type' => ($this->db->dbdriver == "postgre") ? 'TEXT' : 'LONGTEXT',
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
					'constraint' => 45,
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
					'constraint' => 45,
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
					'constraint' => 45,
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
					'constraint' => 45,
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

		//ipv6 migration
		$fields = $this->db->field_data('trending');
		
		if (config_item('db_driver') != 'sqlite' && $fields[1]->max_length < 45) 
		{
			$db_prefix = config_item('db_prefix');
			
			if ($this->db->dbdriver == "postgre") 
			{
				$this->db->query("ALTER TABLE " . $db_prefix . "trending ALTER COLUMN ip_address TYPE VARCHAR(45), ALTER COLUMN ip_address SET NOT NULL, ALTER COLUMN ip_address SET DEFAULT '0'");
				$this->db->query("ALTER TABLE " . $db_prefix . "pastes ALTER COLUMN ip_address TYPE VARCHAR(45), ALTER COLUMN ip_address SET NOT NULL, ALTER COLUMN ip_address SET DEFAULT '0'");
				$this->db->query("ALTER TABLE " . $db_prefix . "blocked_ips ALTER COLUMN ip_address TYPE VARCHAR(45), ALTER COLUMN ip_address SET NOT NULL, ALTER COLUMN ip_address SET DEFAULT '0'");
				$this->db->query("ALTER TABLE " . $db_prefix . "sessions ALTER COLUMN ip_address TYPE VARCHAR(45), ALTER COLUMN ip_address SET NOT NULL, ALTER COLUMN ip_address SET DEFAULT '0'");
			}
			else
			{
				$this->db->query("ALTER TABLE " . $db_prefix . "trending CHANGE COLUMN ip_address ip_address VARCHAR(45) NOT NULL DEFAULT '0'");
				$this->db->query("ALTER TABLE " . $db_prefix . "pastes CHANGE COLUMN ip_address ip_address VARCHAR(45) NOT NULL DEFAULT '0'");
				$this->db->query("ALTER TABLE " . $db_prefix . "blocked_ips CHANGE COLUMN ip_address ip_address VARCHAR(45) NOT NULL DEFAULT '0'");
				$this->db->query("ALTER TABLE " . $db_prefix . "sessions CHANGE COLUMN ip_address ip_address VARCHAR(45) NOT NULL DEFAULT '0'");
			}
		}

		//expand title to 50
		$fields = $this->db->field_data('pastes');
		foreach ($fields as $field) 
		{
			
			if ($field->name == 'title') 
			{
				
				if (config_item('db_driver') != 'sqlite' && $field->max_length < 50) 
				{
					$db_prefix = config_item('db_prefix');
					
					if ($this->db->dbdriver == "postgre") 
					{
						$this->db->query("ALTER TABLE " . $db_prefix . "pastes ALTER COLUMN title TYPE VARCHAR(50), ALTER COLUMN title SET NOT NULL");
					}
					else
					{
						$this->db->query("ALTER TABLE " . $db_prefix . "pastes CHANGE COLUMN title title VARCHAR(50) NOT NULL");
					}
				}
			}
		}

		//upgrade to CI 3.1.2
		$fields = $this->db->field_data('sessions');
		
		if ($field->max_length < 128) 
		{
			$db_prefix = config_item('db_prefix');
			
			if ($this->db->dbdriver == "postgre") 
			{
				$this->db->query("ALTER TABLE " . $db_prefix . "sessions ALTER COLUMN id SET DATA TYPE varchar(128)");
			}
			else
			{
				$this->db->query("ALTER TABLE " . $db_prefix . "sessions CHANGE id id VARCHAR(128) NOT NULL");
			}
		}
	}
	
	function _form_prep($lang = false, $title = '', $paste = '', $reply = false) 
	{
		$this->load->model('languages');
		$this->load->helper('form');
		$data['languages'] = $this->languages->get_languages();
		
		if (config_item('js_editor') == 'codemirror') 
		{

			//codemirror languages
			$this->load->config('codemirror_languages');
			$codemirror_languages = config_item('codemirror_languages');
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
		}
		
		if (config_item('js_editor') == 'ace') 
		{

			//ace languages
			$this->load->config('ace_languages');
			$ace_languages = config_item('ace_languages');
			$data['ace_languages'] = $ace_languages;

			//ace modes
			$acem = array();
			foreach ($ace_languages as $geshi_name => $l) 
			{
				$acem[$geshi_name] = $l;
			}
			$data['ace_modes'] = $acem;
		}

		//recaptcha
		$data['use_recaptcha'] = $this->use_recaptcha;
		$data['recaptcha_publickey'] = $this->recaptcha_publickey;
		
		if (!$this->input->post('submit')) 
		{
			
			if (!$this->session->userdata('expire')) 
			{
				$default_expiration = config_item('default_expiration');
				$this->session->set_userdata('expire', $default_expiration);
			}
			
			if (!$this->session->userdata('snipurl')) 
			{
				$shorturl_selected = config_item('shorturl_selected');
				$this->session->set_userdata('snipurl', $shorturl_selected);
			}
			
			if ($this->session->flashdata('settings_changed')) 
			{
				$data['status_message'] = 'Settings successfully changed';
			}
			$data['name_set'] = $this->session->userdata('name');
			$data['expire_set'] = $this->session->userdata('expire');
			$data['private_set'] = $this->session->userdata('private');
			$data['snipurl_set'] = $this->session->userdata('snipurl');
			$data['paste_set'] = $paste;
			$data['title_set'] = $title;
			$data['reply'] = $reply;
			
			if (!$lang) 
			{
				$lang = config_item('default_language');
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
			$this->form_validation->set_message('min_length', lang('empty'));
			$this->form_validation->set_error_delimiters('<div class="message error"><div class="container">', '</div></div>');
			
			if ($this->form_validation->run() == FALSE) 
			{
				$data = $this->_form_prep();
				$this->load->view('home', $data);
			}
			else
			{
				
				if (config_item('private_only')) 
				{
					$_POST['private'] = 1;
				}
				
				if (config_item('disable_shorturl')) 
				{
					$_POST['snipurl'] = 0;
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
					$this->session->set_userdata($user_data);
				}
				redirect($this->pastes->createPaste());
			}
		}
	}
	
	function post_encrypted() 
	{
		$this->load->model('pastes');
		$_POST['private'] = 1;
		$_POST['snipurl'] = 0;
		$ret_url = $this->pastes->createPaste();
		echo $ret_url;
	}
	
	function raw() 
	{
		$this->_valid_authentication();
		$this->load->model('pastes');
		$check = $this->pastes->checkPaste(3);
		
		if ($check) 
		{
			$data = $this->pastes->getPaste(3);
			
			if (isset($_GET['preview'])) 
			{
				$this->load->helper('text');
				$data['raw'] = character_limiter($data['raw'], 500);
			}
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
			$data['page_title'] = $paste['title'] . ' - ' . config_item('site_name');
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
			$data = $this->pastes->getPaste(3, true, $this->uri->segment(4) == 'diff');
			$this->load->view('view/embed', $data);
		}
		else
		{
			show_404();
		}
	}
	
	function qr() 
	{
		$this->load->model('pastes');
		$check = $this->pastes->checkPaste(3);
		
		if ($check) 
		{
			$data = $this->pastes->getPaste(3);
			$this->load->view('view/qr', $data);
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
		
		if (config_item('private_only')) 
		{
			show_404();
		}
		else
		{
			$this->load->model('pastes');
			
			if ($this->uri->segment(2) == 'rss') 
			{
				$this->load->helper('text');
				$data = $this->pastes->getLists('lists/', 3);
				$data['page_title'] = config_item('site_name');
				$data['feed_url'] = site_url('lists/rss');
				$data['replies'] = $data['pastes'];
				unset($data['pastes']);
				$this->load->view('view/rss', $data);
			}
			else
			{
				$data = $this->pastes->getLists('lists/', 2);
				$this->load->view('list', $data);
			}
		}
	}
	
	function trends() 
	{
		$this->_valid_authentication();
		
		if (config_item('private_only')) 
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
			
			if ($this->session->userdata('view_raw')) 
			{
				redirect('view/raw/' . $this->uri->segment(2));
			}
			$data = $this->pastes->getPaste(2, true, $this->uri->segment(3) == 'diff');
			$data['reply_form'] = $this->_form_prep($data['lang_code'], 'Re: ' . $data['title'], $data['raw'], $data['pid']);
			
			if ($data['private'] == 1) 
			{
				$data['reply_form']['use_recaptcha'] = 0;
			}
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
		
		if ($key != config_item('cron_key')) 
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
		for ($i = 0;$i < 8;$i++) 
		{
			$str.= substr($pool, mt_rand(0, strlen($pool) - 1) , 1);
		}
		$word = $str;

		//save
		$this->session->set_userdata(array(
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
		$this->form_validation->set_message('_valid_lang', lang('valid_lang'));
		return $this->languages->valid_language($lang);
	}
	
	function _valid_captcha($text) 
	{
		
		if (config_item('enable_captcha') && $this->session->userdata('is_human') === null) 
		{
			$this->form_validation->set_message('_valid_captcha', lang('captcha'));
			
			if ($this->use_recaptcha) 
			{
				
				if ($this->_valid_recaptcha()) 
				{
					$this->session->set_userdata('is_human', true);
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				
				if (strtolower($text) == strtolower($this->session->userdata('captcha'))) 
				{
					$this->session->set_userdata('is_human', true);
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		else
		{
			return true;
		}
	}
	
	function _valid_recaptcha() 
	{
		
		if ($this->recaptcha_privatekey == null || $this->recaptcha_privatekey == '') 
		{
			die("To use reCAPTCHA you must get an API key from <a href='https://www.google.com/recaptcha/admin/create'>https://www.google.com/recaptcha/admin/create</a>");
		}
		
		if ($this->input->post('g-recaptcha-response')) 
		{
			$pk = $this->recaptcha_privatekey;
			$ra = $_SERVER['REMOTE_ADDR'];
			$rf = trim($this->input->post('g-recaptcha-response'));
			$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $pk . "&response;=" . $rf . "&remoteip;=" . $ra;
			$response = $this->curl->simple_get($url);
			$status = json_decode($response, true);
			$recaptcha_response = new stdClass();
			
			if ($status['success']) 
			{
				$recaptcha_response->is_valid = true;
			}
			else
			{
				$recaptcha_response->is_valid = false;
			}
			return $recaptcha_response;
		}
		else
		{
			return false;
		}
	}
	
	function _valid_ip() 
	{

		//get ip
		$ip_address = $this->input->ip_address();
		
		if (stristr($ip_address, ':')) 
		{
			return $this->_valid_ipv6($ip_address);
		}
		else
		{
			return $this->_valid_ipv4($ip_address);
		}
	}
	
	function _valid_ipv4($ip_address) 
	{

		//get ip range
		$ip = explode('.', $ip_address);
		$ip_firstpart = $ip[0] . '.' . $ip[1] . '.';

		//setup message
		$this->form_validation->set_message('_valid_ip', lang('not_allowed'));

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
	
	function _valid_ipv6($ip_address) 
	{

		//setup message
		$this->form_validation->set_message('_valid_ip', lang('not_allowed'));

		//lookup
		$this->db->select('ip_address, spam_attempts');
		$this->db->where('ip_address', $ip_address);
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
		$this->form_validation->set_message('_blockwords_check', lang('blocked_words'));

		//check
		$blocked_words = config_item('blocked_words');
		$post = $this->input->post();
		$raw = $post['code'];
		
		if (!$blocked_words) 
		{
			return true;
		}

		//we have blocked words
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
		$this->form_validation->set_message('_autofill_check', lang('robot'));

		//check
		return (!$this->input->post('email') && !$this->input->post('url'));
	}
	
	function _valid_authentication() 
	{
		
		if (config_item('require_auth')) 
		{
			
			if (!$this->auth_ldap->is_authenticated()) 
			{
				$this->session->set_flashdata('tried_to', "/" . $this->uri->uri_string());
				redirect('/auth');
			}
		}
	}
	
	function get_cm_js() 
	{
		$lang = $this->uri->segment(3);
		$this->load->config('codemirror_languages');
		$cml = config_item('codemirror_languages');

		//file path
		$file_path = 'themes/' . config_item('theme') . '/js/';
		
		if (!file_exists($file_path)) 
		{
			$file_path = 'themes/default/js/';
		}
		
		if (isset($cml[$lang]) && gettype($cml[$lang]) == 'array') 
		{
			header('Content-Type: application/x-javascript; charset=utf-8');
			header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 60 * 60 * 24 * 30));
			foreach ($cml[$lang]['js'] as $js) 
			{
				echo file_get_contents($file_path . $js[0]);
			}
		}
		exit;
	}
	
	function error_404() 
	{
		show_404();
	}
	
	function robots_txt() 
	{
		
		if (config_item('disallow_search_engines')) 
		{
			header('Content-Type: text/plain; charset=utf-8');
			$this->load->view('robots_txt');
		}
		else
		{
			echo '';
		}
	}
}
