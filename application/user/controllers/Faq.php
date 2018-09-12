<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $this->data->breadcumburl = site_url('Faq');
        $this->data->breadcumb = 'Faq';
        $this->load->view('Faq', $this->data);
    }

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */