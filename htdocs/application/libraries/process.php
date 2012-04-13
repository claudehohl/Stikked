<?php

/** 
* Source code processing
* 
* @author Ben McRedmond <hello@benmcredmond.com>
* @copyright Ben McRedmond
* @package Stikked
*
*/

include_once('geshi/geshi.php');

/** 
* Source code processing class / Geshi Wrapper
*
* @author Ben McRedmond <hello@benmcredmond.com>
* @version 0.5.1
* @access public
* @copyright Ben McRedmond
* @package Stikked
* @subpackage Libraries
*
*/

Class Process {
		
	/** 
	* Runs source code through Geshi syntax highlighting engine.
	*
	* @param string $source Source code to process
	* @param string $lang Language of source code
	* @return string
	* @access public
	*/
	
	function syntax($source, $lang) {
		$source = $source;
		$language = $lang;	
			
		$geshi =& new Geshi($source, $lang);
		$geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
		$geshi->set_header_type(GESHI_HEADER_DIV);
	
		return $geshi->parse_code();
	}
}

?>