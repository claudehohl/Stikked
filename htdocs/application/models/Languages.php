<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - valid_language()
 * - get_languages()
 * - code_to_description()
 * Classes list:
 * - Languages extends CI_Model
 */

class Languages extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->config('geshi_languages');
		$this->geshi_languages = $this->config->item('geshi_languages');
		$this->load->config('config');
		$this->favorite_languages = $this->config->item('favorite_languages');
	}
	
	function valid_language($lang) 
	{
		return array_key_exists($lang, $this->geshi_languages);
	}
	
	function get_languages() 
	{
		$data = array();
		
		if (is_array($this->favorite_languages)) 
		{
			foreach ($this->favorite_languages as $key) 
			{
				$data[$key] = $this->geshi_languages[$key];
			}
			$data["0"] = "-----------------";
		}
		foreach ($this->geshi_languages as $key => $value) 
		{
			
			if (!in_array($key, $a)) 
			{
				$data[$key] = $value;
			}
		}
		return $data;
	}
	
	function code_to_description($code) 
	{
		return $this->geshi_languages[$code];
	}
}
