<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pencarian extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data->item_with_item_detil = function ($i_nama) {
            return $this->item->with_item_detil()->where('i_nama LIKE', '%' . $i_nama . '%')->get_all();
        };
    }

    public function index()
    {
        $cari = $_GET['keyword'];
        $this->data->keyword = $cari;
        $this->data->keywords = $this->item->select_pencarian($cari);
        $this->load->view('Pencarian', $this->data);

    }
}