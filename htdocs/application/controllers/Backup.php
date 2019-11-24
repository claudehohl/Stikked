<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Backup extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        //protection
        $user = $this->config->item('backup_user');
        $pass = $this->config->item('backup_pass');

        if ($user == '' || $pass == '' || !isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] != $user || $_SERVER['PHP_AUTH_PW'] != $pass) {
            header('WWW-Authenticate: Basic realm="Backup"');
            header('HTTP/1.0 401 Unauthorized');
            exit;
        }
    }

    public function index()
    {

        // Load the DB utility class
        $this->load->dbutil();

        // Backup your entire database and assign it to a variable
        $backup = &$this->dbutil->backup();

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('stikked.gz', $backup);
    }
}
