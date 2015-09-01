<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - index()
 * Classes list:
 * - Unittest extends CI_Controller
 */

class Unittest extends CI_Controller
{
	
	function __construct() 
	{
		parent::__construct();

		//protection
		
		if ($_SERVER['HTTP_HOST'] != 'stikked') 
		{
			exit;
		}
	}
	
	function index() 
	{
		$this->load->library('unit_test');
		$this->load->model('pastes');

		//self test
		$test = 1 + 1;
		$expected_result = 2;
		$test_name = 'Self test: Adds one plus one';
		$this->unit->run($test, $expected_result, $test_name);

		//manipulation: create paste
		$_POST['code'] = '<?php echo "hello world!";';
		$_POST['lang'] = 'php';
		$_POST['title'] = 'hello world';
		$_POST['name'] = 'stikkeduser';
		$pid = $this->pastes->createPaste();

		//paste created, has pid
		$test = $pid;
		$expected_result = 'is_string';
		$test_name = 'Create paste, has pid';
		$this->unit->run($test, $expected_result, $test_name);
		$pid = str_replace('view/', '', $pid);

		//manipulation: delete paste
		$this->pastes->delete_paste($pid);

		//report
		echo $this->unit->report();
	}
}
