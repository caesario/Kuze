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
        $this->data->img1 = $this->billboard->get(1);
        $this->data->img2 = $this->billboard->get(2);
        $this->data->img3 = $this->billboard->get(3);
        $this->data->img4 = $this->billboard->get(4);
        $this->data->img5 = $this->billboard->get(5);
        $this->data->terbaru_items = function () {
            return $this->item
                ->with_item_detil()
                ->order_by('created_at')
                ->limit(8)
                ->get_all();
        };

        $this->data->best_sellers = function () {
            return $this->item->where_i_best('1')
                ->with_item_detil()
                ->order_by('created_at')
                ->limit(8)
                ->get_all();
        };

        $this->data->new_arrivals = function () {
            return $this->item->where_i_new('1')
                ->with_item_detil()
                ->order_by('created_at')
                ->limit(8)
                ->get_all();
        };

        $this->data->sale_items = function () {
            return $this->item->where_i_sale('1')
                ->with_item_detil()
                ->order_by('created_at')
                ->limit(8)
                ->get_all();
        };

        $this->data->rand_image = $this->item_img->select_random();

        $this->data->img_promos = $this->slide_promo->get_all();
        $this->load->view('Home', $this->data);
    }

    public function produkbaru()
    {
        $this->data->terbaru_items = function () {
            return $this->item
                ->with_item_detil()
                ->order_by('created_at')
                ->limit(8)
                ->get_all();
        };
        $this->data->breadcumburl = site_url('produk-terbaru');
        $this->data->breadcumb = 'Produk Terbaru';
        $this->load->view('Produk_baru', $this->data);
    }

    public function item($i_url)
    {
        $this->data->item =  $this->item
            ->with_item_detil()
            ->where('i_url', $i_url)
            ->get();
        $this->data->breadcumburl = site_url('produk-terbaru');
        $this->data->breadcumburl1 = site_url('produk-terbaru/item/' . $i_url . '/detil');
        $this->data->breadcumb = 'Produk Terbaru';
        $this->data->breadcumb1 = $this->item->where('i_url', $i_url)->get()->i_nama;

        $this->load->view('Detil', $this->data);
    }

    public function hot($i_url)
    {
        $this->data->item = $this->item
            ->with_item_detil()
            ->where('i_url', $i_url)
            ->get();
        $this->data->breadcumburl = site_url('hot-item');
        $this->data->breadcumburl1 = site_url('hot-item/item/' . $i_url . '/detil');
        $this->data->breadcumb = 'Hot Item';
        $this->data->breadcumb1 = $this->item->where('i_url', $i_url)->get()->i_nama;

        $this->load->view('Detil', $this->data);
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */