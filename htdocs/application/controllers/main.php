<?php

/** 
* Main Controller for Stikked
* 
* @author Ben McRedmond <hello@benmcredmond.com>
* @copyright Ben McRedmond
* @package Stikked
*
*/

/** 
* Main controller class for stikked.
*
* @author Ben McRedmond <hello@benmcredmond.com>
* @version 0.5.1
* @access public
* @copyright Ben McRedmond
* @package Stikked
* @subpackage Controllers
*
*/

class Main extends CI_Controller 
{

	/** 
	* Class Constructor, loads languages model which is inherited in the pastes model.
	*
	* @return void
	*/

	function __construct() 
	{
		parent::__construct();
		$this->load->model('languages');
	}
	
	
	/** 
	* Sets all the fields in a paste form, depending on whether the form is being repopulated or items need to be loaded from session data.
	*
	* @param string $lang Paste language
	* @param string $title Paste title
	* @param string $paste Paste body
	* @param bool|string $reply Is this paste a reply? Bool if not, otherwise it's the id of the paste.
	* @return Array
	* @access private
	* @see index()
	* @see view()
	*/	
	
	function _form_prep($lang='php', $title = '', $paste='', $reply=false)
	{
		$this->load->model('languages');
		$this->load->helper("form");
		
		$data['languages'] = $this->languages->get_languages();		
		$data['scripts'] = array('jquery.js', 'jquery.timers.js');
		
		if(!$this->input->post('submit'))
		{
			if($this->db_session->flashdata('settings_changed'))
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

			if($lang != 'php' or ($lang == 'php' and $this->db_session->userdata('lang') == false))
			{
				$data['lang_set'] = $lang;
			}
			elseif($this->db_session->userdata('lang'))
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
	
	
	/** 
	* Controller method to load front page.
	*
	* @return void
	* @access public
	* @see _form_prep()
	* @see _valid_lang()
	*/
	
	function index()
	{
		if(!isset($_POST['submit']))
		{
			$data = $this->_form_prep();
			$this->load->view('home', $data);
		}
		else
		{
			$this->load->model('pastes');
			$this->load->library('form_validation');
		
			$rules['code'] = 'required';
			$rules['lang'] = 'min_length[1]|required|callback__valid_lang';

			$fields['code'] = 'Main Paste';
			$fields['lang'] = 'Language';
			
			$this->form_validation->set_rules($rules);
			//$this->form_validation->set_fields($fields);
			$this->form_validation->set_message('min_length', 'The %s field can not be empty');
			$this->form_validation->set_error_delimiters('<div class="message error"><div class="container">', '</div></div>');
			
			if ($this->form_validation->run() == FALSE)
			{
				$data = $this->_form_prep();
				$this->load->view('home', $data);
			}
			else
			{
				if(isset($_POST['acopy']) and $_POST['acopy'] > 0)
				{
					$this->db_session->set_flashdata('acopy', 'true');
				}
				
				if($this->input->post('remember') and $this->input->post('reply') == false )
				{
					$user_data = array(
							'name' => $this->input->post('name'),
							'lang' => $this->input->post('lang'),
							'expire' => $this->input->post('expire'),
							'acopy' => $this->input->post('acopy'),
							'snipurl' => $this->input->post('snipurl'),
							'private' => $this->input->post('private'),
							'remember' => $this->input->post('remember')
						);
					$this->db_session->set_userdata($user_data);
				}
				
				if($this->input->post('remember') == false and $this->db_session->userdata("remember") == 1)
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
	
	
	/** 
	* Controller method to load raw pastes.
	*
	* @return void
	* @access public
	*
	*/
		
	function raw()
	{
		$this->load->model('pastes');
		$check = $this->pastes->checkPaste(3);
		if($check)
		{
		
			$data = $this->pastes->getPaste(3);
			$this->load->view('view/raw', $data);
		}
		else
		{
			show_404();
		}
	}
	
	
	/** 
	* Controller method to download pastes.
	*
	* @return void
	* @access public
	*
	*/
	
	function download()
	{
		$this->load->model('pastes');
		$check = $this->pastes->checkPaste(3);
		if($check)
		{
			$data = $this->pastes->getPaste(3);
			$this->load->view('view/download', $data);
		}
		else
		{
			show_404();
		}
	
	}
	
	
	/** 
	* Controller method to show recent pastes.
	*
	* @return void
	* @access public
	*
	*/
	
	function lists()
	{
		$this->load->model('pastes');
		$data = $this->pastes->getLists();
		$this->load->view('list', $data);
	}
	
		
	/** 
	* Controller method to show a paste.
	*
	* @return void
	* @access public
	*
	*/
	
	function view() 
	{
		$this->load->model('pastes');	

		$check = $this->pastes->checkPaste(2);
				
		if($check)
		{
			
			if($this->db_session->userdata('view_raw'))
			{
				$this->db_session->keep_flashdata('acopy');
				redirect('view/raw/'.$this->uri->segment(2));
			}
			
			$data = $this->pastes->getPaste(2, true);
			$data['reply_form'] = $this->_form_prep($data['lang_code'], "RE: ".$data['title'], $data['raw'], $data['pid']);
			
			if($this->db_session->userdata('full_width'))
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
	
	
	/** 
	* Loads data for view_options from session data or not if not set.
	*
	* @return array
	* @access private
	*
	*/
	
	function _view_options_prep()
	{
		$this->load->helper('form');
		if($this->db_session->userdata('remember_view') > 0)
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
	
	
	/** 
	* Displays the page where a user can change their paste viewing settings which are saved to session data.
	*
	* @return void
	* @access public
	*
	*/
	
	function view_options()
	{
		if(!isset($_POST['submit']))
		{
			$data = $this->_view_options_prep();
			$this->load->view('view/view_options', $data);
		}
		else
		{
			$this->load->library('form_validation');
			
			$rules['full_width'] = 'max_length[1]';
			$rules['view_raw'] = 'max_length[1]';
			
			$this->form_validation->set_rules($rules);
			
			if($this->form_validation->run() == false)
			{
				exit('Ugh, stupid skiddie.');
			}
			else
			{
				$user_data = array(
					'full_width' => $this->input->post('full_width'),
					'view_raw' => $this->input->post('view_raw'),
					'remember_view' => true
					);
				$this->db_session->set_userdata($user_data);
				$this->db_session->set_flashdata('settings_changed', 'true');
				redirect();
			}
		}
	}
	
	
	/** 
	* Controller method to run the cron. Requires a valid cron key supplied as an argument in the url.
	*
	* @return void;
	* @access public
	*
	*/
	
	function cron()
	{
		$this->load->model('pastes');
		$key = $this->uri->segment(2);
		if($key != $this->config->item('cron_key'))
		{
			show_404();
		}
		else
		{
			$this->pastes->cron(); 
			return 0;
		}
	}
	
	
	/** 
	* Controller method to load about view.
	*
	* @return void
	* @access public
	*
	*/
		
	function about()
	{
		$this->load->view('about');
	}
	
	
	/** 
	* Validation callback method to validate whether the paste language is valid. 
	*
	* @return bool
	* @access private
	* @see index()
	*
	*/
	
	function _valid_lang($lang) 
	{
		$this->load->model('languages');
		$this->form_validation->set_message('_valid_lang', 'Please select your language');
		return $this->languages->valid_language($lang);
	}
}
?>
