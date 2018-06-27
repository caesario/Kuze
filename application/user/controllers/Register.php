<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('Register');
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */