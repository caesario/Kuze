<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aboutus extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $this->data->breadcumburl = site_url('Aboutus');
        $this->data->breadcumb = 'Aboutus';
        $this->load->view('Aboutus', $this->data);
    }

}

/* End of file Home.php */
/* Location: ./application/contro   llers/Home.php */