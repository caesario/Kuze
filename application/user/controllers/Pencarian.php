<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pencarian extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $cari = $_GET['keyword'];
        $this->data->keyword = $cari;
        $this->data->keywords = $this->item->select_pencarian($cari);
        $this->load->view('Pencarian', $this->data);

    }
}