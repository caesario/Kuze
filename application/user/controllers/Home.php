<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();


    }

    public function index()
    {

        $this->data->event = $this->event->limit(3)->get_all();
        $this->data->rand_image = $this->item_img->select_random();
        $this->load->view('Home', $this->data);

    }


    public function item($i_url)
    {

        $this->data->item = $this->item
            ->with_item_detil()
            ->where('i_url', $i_url)
            ->get();
        $this->data->breadcumburl = site_url('produk-terbaru');
        $this->data->breadcumburl1 = site_url('produk-terbaru/item/' . $i_url . '/detil');
        $this->data->breadcumb = 'Produk Terbaru';
        $this->data->breadcumb1 = $this->item->where('i_url', $i_url)->get()->i_nama;

        $this->load->view('Detil', $this->data);

    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */