<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->session->set_userdata('current_url', $this->uri->uri_string());
    }

    public function index()
    {

        $this->data->event = $this->event->limit(3)->get_all();
//        $this->data->img1 = $this->billboard->get(1);
//        $this->data->img2 = $this->billboard->get(2);
//        $this->data->img3 = $this->billboard->get(3);
//        $this->data->img4 = $this->billboard->get(4);
//        $this->data->img5 = $this->billboard->get(5);
//        $this->data->terbaru_items = function () {
//            return $this->item
//                ->with_item_detil()
//                ->order_by('created_at')
//                ->limit(8)
//                ->get_all();
//        };
//
//        $this->data->best_sellers = function () {
//            return $this->item->where_i_best('1')
//                ->with_item_detil()
//                ->order_by('created_at', 'DESC')
//                ->limit(8)
//                ->get_all();
//        };
//
//        $this->data->new_arrivals = function () {
//            return $this->item->where_i_new('1')
//                ->with_item_detil()
//                ->order_by('created_at', 'DESC')
//                ->limit(8)
//                ->get_all();
//        };
//
//        $this->data->sale_items = function () {
//            return $this->item->where_i_sale('1')
//                ->with_item_detil()
//                ->order_by('created_at', 'DESC')
//                ->limit(8)
//                ->get_all();
//        };

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

    private function get_image($i_kode)
    {
        $data = $this->item_img
            ->where(array('i_kode' => $i_kode))->order_by('created_at', 'DESC')
            ->get();

        if ($data != NULL) {
            $image = new Imagick();
            $image->readimageblob($data->ii_data);
            $image->setImageCompressionQuality(80);

//            $fisik = fopen('./upload/' . $data->ii_kode .'.png' ,"w");
//            fwrite($fisik, $image->getimageblob());
//            fclose($fisik);
            $hasil = "data:" . $data->ii_type . ";base64," . (base64_encode($image->getimageblob()));
        } else {
            $hasil = base_url('assets/img/noimage.jpg');
        }

        return $hasil;
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
//        if (!$this->cache->get('home_produkbaru')) {
//            $this->data->terbaru_items = function () {
//                return $this->item
//                    ->with_item_detil()
//                    ->order_by('created_at')
//                    ->limit(8)
//                    ->get_all();
//            };
//            $this->data->breadcumburl = site_url('produk-terbaru');
//            $this->data->breadcumb = 'Produk Terbaru';
//
//            // Save into the cache for 5 minutes
//            $this->cache->save('home_produkbaru', $this->data, 300);
//            $this->load->view('Produk_baru', $this->data);
//        } else {
//            $this->load->view('Produk_baru', $this->cache->get('home_produkbaru'));
//        }

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
//        if (!$this->cache->get('home_item')) {
//            $this->data->item = $this->item
//                ->with_item_detil()
//                ->where('i_url', $i_url)
//                ->get();
//            $this->data->breadcumburl = site_url('produk-terbaru');
//            $this->data->breadcumburl1 = site_url('produk-terbaru/item/' . $i_url . '/detil');
//            $this->data->breadcumb = 'Produk Terbaru';
//            $this->data->breadcumb1 = $this->item->where('i_url', $i_url)->get()->i_nama;
//
//            // Save into the cache for 5 minutes
//            $this->cache->save('home_item', $this->data, 300);
//            $this->load->view('Detil', $this->data);
//        } else {
//            $this->load->view('Detil', $this->cache->get('home_item'));
//        }

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