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
        $cari = $this->input->get('cari');
        $this->data->cari_s = $this->item->with_item_detil()->where('i_nama LIKE', '%' . $cari . '%')->get_all();
        $this->load->view('Pencarian', $this->data);

    }
}