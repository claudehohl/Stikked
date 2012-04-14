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
		
		if (!$this->db->table_exists('pastes')) 
		{
			$this->db->simple_query(<<<EOT
--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `code` varchar(12) character set utf8 collate utf8_unicode_ci NOT NULL,
  `description` varchar(32) character set utf8 collate utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`code`, `description`) VALUES
('c', 'C'),
('css', 'CSS'),
('cpp', 'C++'),
('html4strict', 'HTML (4 Strict)'),
('java', 'Java'),
('perl', 'Perl'),
('php', 'PHP'),
('python', 'Python'),
('ruby', 'Ruby'),
('text', 'Plain Text'),
('asm', 'ASM (Nasm Syntax)'),
('xhtml', 'XHTML'),
('actionscript', 'Actionscript'),
('ada', 'ADA'),
('apache', 'Apache Log'),
('applescript', 'AppleScript'),
('autoit', 'AutoIT'),
('bash', 'Bash'),
('bptzbasic', 'BptzBasic'),
('c_mac', 'C for Macs'),
('csharp', 'C#'),
('ColdFusion', 'coldfusion'),
('delphi', 'Delphi'),
('eiffel', 'Eiffel'),
('fortran', 'Fortran'),
('freebasic', 'FreeBasic'),
('gml', 'GML'),
('groovy', 'Groovy'),
('inno', 'Inno'),
('java5', 'Java 5'),
('javascript', 'Javascript'),
('latex', 'LaTeX'),
('mirc', 'mIRC'),
('mysql', 'MySQL'),
('nsis', 'NSIS'),
('objc', 'Objective C'),
('ocaml', 'OCaml'),
('oobas', 'OpenOffice BASIC'),
('orcale8', 'Orcale 8 SQL'),
('pascal', 'Pascal'),
('plsql', 'PL/SQL'),
('qbasic', 'Q(uick)BASIC'),
('robots', 'robots.txt'),
('scheme', 'Scheme'),
('sdlbasic', 'SDLBasic'),
('smalltalk', 'Smalltalk'),
('smarty', 'Smarty'),
('sql', 'SQL'),
('tcl', 'TCL'),
('vbnet', 'VB.NET'),
('vb', 'Visual BASIC'),
('winbatch', 'Winbatch'),
('xml', 'XML'),
('z80', 'z80 ASM');
EOT;
			);
		}
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
