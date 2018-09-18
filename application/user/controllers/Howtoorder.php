<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Howtoorder extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $this->data->breadcumburl = site_url('Howtoorder');
        $this->data->breadcumb = 'howtoorder';
        $this->load->view('Howtoorder', $this->data);
    }

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */