<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Item_img_m', 'item_img');
        $this->load->model('Slide_promo_m', 'slide_promo');
        $this->load->model('Billboard_m', 'billboard');
        $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'file'));

    }

    public function item($i_kode)
    {
        $data = $this->item_img
            ->where(array('i_kode' => $i_kode))->order_by('created_at', 'DESC')
            ->get();

        if ($data != NULL) {
            $image = new Imagick();
            $image->readimageblob($data->ii_data);
            $image->setImageCompressionQuality(80);

            $hasil = "data:" . $data->ii_type . ";base64," . (base64_encode($image->getimageblob()));
        } else {
            $hasil = base_url('assets/img/noimage.jpg');
        }

        return $hasil;
    }

    public function slide()
    {
        ob_start('ob_gzhandler');
        $hasil = array();
//        if (!$this->cache->get('slide')) {
//            $promos = $this->slide_promo->where('slide_promo_isaktif', 1)->get_all();
//            if ($promos) {
//                foreach ($promos as $k => $v) {
//                    $image = new Imagick();
//                    $image->readimageblob($v->slide_promo_data);
//                    $image->setImageCompressionQuality(80);
//
//                    $hasil[$k]['url'] = $this->view_image($v->slide_promo_type, $image->getImageBlob());
//                    $hasil[$k]['caption'] = $v->slide_promo_caption;
//                    $hasil[$k]['type'] = "image";
//
//                }
//
//                $this->cache->save('slide', $hasil, 300);
//            } else {
//                $hasil = NULL;
//            }
//        } else {
//            $hasil = $this->cache->get('slide');
//        }

        $promos = $this->slide_promo->where('slide_promo_isaktif', 1)->get_all();
        if ($promos) {
            foreach ($promos as $k => $v) {
                $image = new Imagick();
                $image->readimageblob($v->slide_promo_data);
                $image->setImageCompressionQuality(80);

                $hasil[$k]['url'] = $this->view_image($v->slide_promo_type, $image->getImageBlob());
                $hasil[$k]['caption'] = $v->slide_promo_caption;
                $hasil[$k]['type'] = "image";

            }

            $this->cache->save('slide', $hasil, 300);
        } else {
            $hasil = NULL;
        }

        echo json_encode($hasil);
    }

    public function billboard()
    {
        ob_start('ob_gzhandler');
        $hasil = array();
        if (!$this->cache->get('billboard')) {
            for ($i = 1; $i <= 5; $i++) {
                $tmp = $this->billboard->get($i);

                if ($tmp) {
                    $image = new Imagick();
                    $image->readimageblob($tmp->blb_data);
                    $image->setImageCompressionQuality(80);


                    $hasil[$i]['id'] = $tmp->blb_id;
                    $hasil[$i]['alt'] = $tmp->blb_judul;
                    $hasil[$i]['url'] = $tmp->blb_url;
                    $hasil[$i]['ket'] = $tmp->blb_ket;
                    $hasil[$i]['src'] = $this->view_image($tmp->blb_type, $image->getImageBlob());
                }
            }

            $this->cache->save('billboard', $hasil, 300);
        } else {
            $hasil = $this->cache->get('billboard');
        }


        echo json_encode($hasil, JSON_UNESCAPED_UNICODE);
    }

    private function view_image($mime, $data)
    {
        return 'data:' . $mime . ';base64,' . (base64_encode($data));
    }
}