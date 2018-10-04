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

    public function slide_promo()
    {
        $hasil = array();
        $promos = $this->slide_promo->where('slide_promo_isaktif', 1)->get_all();
        foreach ($promos as $k => $v) {
            $hasil[$k]['url'] = "data:" . $v->slide_promo_type . ";base64," . (base64_encode($v->slide_promo_data));
            $hasil[$k]['caption'] = $v->slide_promo_caption;
            $hasil[$k]['type'] = "image";

        }

        echo json_encode($hasil);

    }

    public function best_seller()
    {
        $hasil = array();
        $data = $this->item->as_array()->where_i_best('1')
            ->order_by('created_at', 'DESC')
            ->limit(8)
            ->get_all();

        foreach ($data as $k => $v) {
            $hasil[$k]['i_kode'] = $v['i_kode'];
            $hasil[$k]['i_url'] = $v['i_url'];
            $hasil[$k]['i_nama'] = $v['i_nama'];
            $hasil[$k]['i_hrg'] = $v['i_hrg'];
            $hasil[$k]['i_img'] = $this->get_image($v['i_kode']);
        }
        echo json_encode($hasil);
    }

    public function new_arrival()
    {
        $hasil = array();
        $data = $this->item->as_array()->where_i_new('1')
            ->order_by('created_at', 'DESC')
            ->limit(8)
            ->get_all();

        foreach ($data as $k => $v) {

            $hasil[$k]['i_kode'] = $v['i_kode'];
            $hasil[$k]['i_url'] = $v['i_url'];
            $hasil[$k]['i_nama'] = $v['i_nama'];
            $hasil[$k]['i_hrg'] = $v['i_hrg'];
            $hasil[$k]['i_img'] = $this->get_image($v['i_kode']);
        }

        echo json_encode($hasil);
    }

    public function sale_item()
    {
        $hasil = array();
        $data = $this->item->as_array()->where_i_sale('1')
            ->order_by('created_at', 'DESC')
            ->limit(8)
            ->get_all();

        foreach ($data as $k => $v) {

            $hasil[$k]['i_kode'] = $v['i_kode'];
            $hasil[$k]['i_url'] = $v['i_url'];
            $hasil[$k]['i_nama'] = $v['i_nama'];
            $hasil[$k]['i_hrg'] = $v['i_hrg'];
            $hasil[$k]['i_img'] = $this->get_image($v['i_kode']);
        }

        echo json_encode($hasil);
    }

    public function get_billboard()
    {
        $hasil = array();
        for ($i = 1; $i <= 5; $i++) {
            $tmp = $this->billboard->get($i);
            $hasil[$i]['id'] = $tmp->blb_id;
            $hasil[$i]['alt'] = $tmp->blb_judul;
            $hasil[$i]['url'] = $tmp->blb_url;
            $hasil[$i]['ket'] = $tmp->blb_ket;
            $hasil[$i]['src'] = "data:" . $tmp->blb_type . ";base64," . (base64_encode($tmp->blb_data));
        }

        echo json_encode($hasil);
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