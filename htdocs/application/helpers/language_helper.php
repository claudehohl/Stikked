<?php
/**
 * Class and Function List:
 * Function list:
 * - lang()
 * - random_expire_msg()
 * Classes list:
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Language Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/language_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Lang
 *
 * Fetches a language variable and optionally outputs a form label
 *
 * @access	public
 * @param	string	the language line
 * @param	string	the id of the form element
 * @return	string
 */

if (!function_exists('lang')) 
{
	
	function lang($index, $id = '') 
	{
		$CI = & get_instance();
		$line = $CI->lang->line($index);
		
		if ($id != '') 
		{
			$line = '<label for="' . $id . '">' . $line . "</label>";
		}
		return ($line != '' ? $line : '[' . $index . ']');
	}
}
/**
 * Random expire msg
 *
 * Displays a random expire message
 *
 * @access	public
 * @return	string
 */

if (!function_exists('random_expire_msg')) 
{
	
	function random_expire_msg() 
	{
		$CI = & get_instance();
		$expires = $CI->config->item('expires');
		return $expires[rand(0, sizeof($expires) - 1) ];
	}
}

// ------------------------------------------------------------------------
/* End of file language_helper.php */


/* Location: ./system/helpers/language_helper.php */
