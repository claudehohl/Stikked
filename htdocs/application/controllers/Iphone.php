<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Iphone extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('languages');
    }

    public function index()
    {
        $this->load->model('pastes');
        $data = $this->pastes->getLists('iphone/');
        $this->load->view('iphone/recent', $data);
    }

    public function view()
    {
        $this->load->model('pastes');
        $data = $this->pastes->getPaste(3);
        $this->load->view('iphone/view', $data);
    }
}
