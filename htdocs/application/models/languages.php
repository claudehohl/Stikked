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
	}
	
	function valid_language($lang) 
	{
		$this->db->where('code', $lang);
		$query = $this->db->get('languages');
		
		if ($query->num_rows() > 0) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function get_languages() 
	{
		$query = $this->db->get('languages');
		$data = array();
		foreach ($query->result_array() as $row) 
		{
			$data[$row['code']] = $row['description'];
			
			if ($row['code'] == 'text') 
			{
				$data["0"] = "-----------------";
			}
		}
		return $data;
	}
	
	function code_to_description($code) 
	{
		$this->db->select('description');
		$this->db->where('code', $code);
		$query = $this->db->get('languages');
		
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result_array() as $row) 
			{
				return $row['description'];
			}
		}
		else
		{
			return false;
		}
	}
}
