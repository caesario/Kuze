<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DetailPesanan extends MY_Controller
{


    public function index()
    {

        $this->load->view('DetailPesanan', $this->data);
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */