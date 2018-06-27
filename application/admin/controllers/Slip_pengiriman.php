<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slip_pengiriman extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('Slip_pengiriman', $this->data);
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */