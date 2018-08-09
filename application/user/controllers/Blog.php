<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data->items = $this->item->limit(10)->get_all();
        $this->data->breadcumburl = site_url('Blog');
        $this->data->breadcumb = 'Blog';
        $this->load->view('Blog', $this->data);
    }

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */