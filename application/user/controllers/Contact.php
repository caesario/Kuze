<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $this->data->breadcumburl = site_url('Contact');
        $this->data->breadcumb = 'Contact';
        $this->load->view('Contact', $this->data);
    }

}

/* End of file Home.php */
/* Location: ./application/contro   llers/Home.php */