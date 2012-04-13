<?php

/** 
* iPhone Controller for Stikked
* 
* @author Ben McRedmond <hello@benmcredmond.com>
* @copyright Ben McRedmond
* @package Stikked
*
*/

/** 
* iPhone controller class for stikked.
*
* @author Ben McRedmond <hello@benmcredmond.com>
* @version 0.5.1
* @access public
* @copyright Ben McRedmond
* @package Stikked
* @subpackage Controllers
*
*/

class Iphone extends CI_Controller 
{
	
	/** 
	* Class Constructor
	*
	* @return void
	*/
	
	function __construct() 
	{
		parent::__construct();
	}
	
	
	/** 
	* Displays recent pastes in an iPhone optimized version.
	*
	* @return void
	* @access public
	*/
	
	function index()
	{
		$this->load->model('pastes');
		$data = $this->pastes->getLists('iphone/');
		$this->load->view('iphone/recent', $data);
	}
	
	
	/** 
	* Displays an individual paste in an iPhone optimized version.
	*
	* @return void
	* @access public
	*/
	
	function view()
	{
		$this->load->model('pastes');
		$data = $this->pastes->getPaste(3);
		$this->load->view('iphone/view', $data);
	}
}

?>
