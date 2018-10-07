<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CI_Controller MY_Controller
 */
class MY_Controller extends CI_Controller
{
    public $data;

    public function __construct()
    {
        ini_set('memory_limit', '1024M');
        parent::__construct();

        $this->data = new stdClass();

        // Library
        $this->load->library('session');
        $this->load->library('Layout');

        // load web config
        $this->load->config('weboptions');

        // load model
        $this->load->model('Alamat_m', 'alamat');
        $this->load->model('Event_m', 'event');
        $this->load->model('Bag_m', 'cart');
        $this->load->model('Item_detil_m', 'item_detil');
        $this->load->model('Item_img_m', 'item_img');
        $this->load->model('Item_kategori_m', 'item_kategori');
        $this->load->model('Item_qty_m', 'item_qty');
        $this->load->model('Item_seri_m', 'item_seri');
        $this->load->model('Item_ukuran_m', 'item_ukuran');
        $this->load->model('Item_warna_m', 'item_warna');
        $this->load->model('Item_m', 'item');
        $this->load->model('Kategori_m', 'kategori');
        $this->load->model('Order_detil_m', 'order_detil');
        $this->load->model('Order_m', 'order');
        $this->load->model('Order_pengiriman_m', 'order_pengiriman');
        $this->load->model('Order_ongkir_m', 'order_ongkir');
        $this->load->model('Order_payment_m', 'order_payment');
        $this->load->model('Order_bukti_m', 'order_bukti');
        $this->load->model('Order_pengguna_m', 'order_pengguna');
        $this->load->model('Order_resi_m', 'order_resi');
        $this->load->model('Seri_m', 'seri');
        $this->load->model('Toko_m', 'toko');
        $this->load->model('Billboard_m', 'billboard');
        $this->load->model('Warna_m', 'warna');
        $this->load->model('Promo_m', 'promo');
        $this->load->model('Bank_m', 'bank');
        $this->load->model('Slide_promo_m', 'slide_promo');
        $this->load->model('Provinsi_m', 'provinsi');
        $this->load->model('Kabupaten_m', 'kabupaten');
        $this->load->model('Kecamatan_m', 'kecamatan');
        $this->load->model('Desa_m', 'desa');
        $this->load->model('Pengguna_m', 'pengguna');
        $this->load->model('Pengguna_alamat_m', 'pengguna_alamat');

        $this->data->meta_title = $this->config->item('webname');
        $this->data->meta_content = $this->config->item('webdeskripsi');
        $this->data->meta_keywords = $this->config->item('webkeywords');

        $menu_kategori = function () {
            $hasil = new ArrayObject();
            $query = $this->kategori->with_item_kategori()->get_all();
            foreach ($query as $q) {
                if ($q->item_kategori != NULL) {
                    $hasil->append($q);
                }
            }

            return $hasil;
        };

        $this->data->menu_kategori = $menu_kategori();
        $this->data->menu_cart = function ($session_id) {
            return $this->cart->with_item_detil()->where('pengguna_kode', $session_id)->get_all();
        };

        $this->session->set_userdata('current_url', $this->uri->uri_string());
        if (isset($_SESSION['current_url']) && $this->uri->uri_string() != 'login') {
            $this->data->current_url = $_SESSION['current_url'];
        }

        // cek user
        if (isset($_SESSION['id'])) {
            $user = $this->pengguna->where('pengguna_kode', $_SESSION['id'])->get();
            if (!$user) {
                $this->session->unset_userdata('id');
                $this->session->unset_userdata('nama');
                $this->session->unset_userdata('username');
                $this->session->unset_userdata('isonline');
            }
        }

        $this->callback();
        $this->load_pref();
        $this->event_load();
        $this->bag_counter();
    }


    private function callback()
    {
        $this->data->item = function ($i_kode) {
            return $this->item
                ->with_item_detil()
                ->where('i_kode', $i_kode)
                ->get();
        };

        $this->data->item_all = function ($i_kode) {
            return $this->item
                ->with_item_detil()
                ->where('i_kode', $i_kode)
                ->get_all();
        };
        $this->data->item_detil_with_item = function ($i_kode) {
            return $this->item_detil
                ->with_item()
                ->with_warna('order_by:w_nama')
                ->with_ukuran('order_by:u_nama')
                ->with_seri()
                ->with_item_img()
                ->where('i_kode', $i_kode)
                ->get();
        };

        $this->data->item_detil_with_item_all = function ($i_kode) {
            return $this->item_detil
                ->with_item()
                ->with_warna('order_by:w_nama')
                ->with_ukuran('order_by:u_nama')
                ->with_seri()
                ->with_item_img()
                ->where('i_kode', $i_kode)
                ->get_all();
        };


        $this->data->item_detil = function ($ide_kode) {
            return $this->item_detil
                ->with_item()
                ->with_warna('order_by:w_nama')
                ->with_ukuran('order_by:u_nama')
                ->with_seri()
                ->with_item_img()
                ->where('item_detil_kode', $ide_kode)
                ->get();
        };

        $this->data->item_detil_all = function ($ide_kode) {
            return $this->item_detil
                ->with_item()
                ->with_warna('order_by:w_nama')
                ->with_ukuran('order_by:u_nama')
                ->with_seri()
                ->with_item_img()
                ->where('item_detil_kode', $ide_kode)
                ->get_all();
        };

//        $this->data->warna = function ($i_kode) {
//            return $this->warna
//                ->with_item_detil('where:i_kode = \'' . $i_kode . '\'')
//                ->get_all();
//        };
//
//        $this->data->ukuran = function ($i_kode) {
//            return $this->ukuran
//                ->with_item_detil('where:i_kode = \'' . $i_kode . '\'')
//                ->get_all();
//        };

        $this->data->qty = function ($i_kode) {
            $hasil = 0;
            $stoks = $this->item_detil->where('i_kode', $i_kode)->with_item_qty()->get();
            if (isset($stoks->item_qty)) {
                foreach ($stoks->item_qty as $stok) {
                    $hasil += $stok->iq_qty;
                }
            } else {
                $hasil = 0;
            }


            return $hasil;
        };

        $this->data->qty_detil = function ($ide_kode) {
            $hasil = 0;
            $stoks = $this->item_detil->where('item_detil_kode', $ide_kode)->with_item_qty()->get();
            foreach ($stoks->item_qty as $stok) {
                $hasil += $stok->iq_qty;
            }

            return $hasil;
        };

        $this->data->item_img = function ($i_kode) {
            $hasil = $this->item_img
                ->where(array('i_kode' => $i_kode))->order_by('created_at', 'DESC')
                ->get();

            if ($hasil) {
                return $hasil;
            } else {
                return NULL;
            }
        };

        $this->data->item_img_count = function ($i_kode) {
            return $this->item_img->counter($i_kode);
        };

        $this->data->item_img_last = function ($i_kode) {
            $hasil = $this->item_img
                ->where('i_kode', $i_kode)->limit(1)->order_by('created_at')
                ->get();

            if ($hasil) {
                return $hasil;
            } else {
                return NULL;
            }
        };

        $this->data->item_img_all = function ($i_kode) {
            return $this->item_img->where(array('i_kode' => $i_kode))->get_all();
        };


        $this->data->bank_s = function () {
            return $this->bank->where('bank_isaktif', 1)->get_all();
        };

        $this->data->base64_encode_image = function ($filename, $filetype) {
            if ($filename) {
                $imgbinary = fread(fopen($filename, "r"), filesize($filename));
                return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
            }
        };
    }

    private function load_pref()
    {
        $toko = $this->toko->get();
        if ($toko) {
            $this->data->brandname = $toko->t_nama;
            $this->data->instagram = $toko->t_insta;
            $this->data->whatsapp = $toko->t_wa;
            $this->data->line = $toko->t_line;
            $this->data->logo = $toko->t_logo;
            $this->data->icon = $toko->t_icon;
            $this->data->email = $toko->t_email;
            $this->data->alamat = $toko->t_alamat;
        } else {
            $this->data->brandname = 'E-Commerce Brand';
            $this->data->instagram = 'insta_ecom';
            $this->data->whatsapp = 'Whatsapp';
            $this->data->line = '';
            $this->data->logo = '';
            $this->data->icon = '';
            $this->data->email = '';
            $this->data->alamat = '';
        }


    }

    private function event_load()
    {
        $event = $this->event->get_all();
        if ($event) {
            $this->data->events = $event;
        } else {
            $this->data->events = '';
        }
    }

    private function bag_counter()
    {
        if (isset($_SESSION['id'])) {
            $this->data->bag_counter = $this->cart->select_count($_SESSION['id']);
        }

    }

    public function get_image($i_kode)
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
}

