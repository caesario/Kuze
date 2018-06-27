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
        parent::__construct();

        $this->data = new stdClass();

        // Library
        $this->load->library('session');
        $this->load->library('Layout');

        // load web config
        $this->load->config('weboptions');

        // load model
        $this->load->model('Alamat_m', 'alamat');
        $this->load->model('Artikel_m', 'artikel');
        $this->load->model('Cart_m', 'cart');
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
        $this->load->model('Ukuran_m', 'ukuran');
        $this->load->model('Warna_m', 'warna');
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
        $this->data->menu_kategori = $this->item_kategori->with_kategori()->group_by('k_kode')->get_all();
        $this->data->menu_cart = function ($session_id) {
            return $this->cart->with_item_detil()->where_pengguna_kode($session_id)->get_all();
        };

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
    }


    private function callback()
    {
        $this->data->item = function ($i_kode) {
            return $this->item
                ->with_item_detil()
                ->where_i_kode($i_kode)
                ->get();
        };

        $this->data->item_all = function ($i_kode) {
            return $this->item
                ->with_item_detil()
                ->where_i_kode($i_kode)
                ->get_all();
        };
        $this->data->item_detil_with_item = function ($i_kode) {
            return $this->item_detil
                ->with_item()
                ->with_warna('order_by:w_nama')
                ->with_ukuran('order_by:u_nama')
                ->with_seri()
                ->with_item_img()
                ->where_i_kode($i_kode)
                ->get();
        };

        $this->data->item_detil_with_item_all = function ($i_kode) {
            return $this->item_detil
                ->with_item()
                ->with_warna('order_by:w_nama')
                ->with_ukuran('order_by:u_nama')
                ->with_seri()
                ->with_item_img()
                ->where_i_kode($i_kode)
                ->get_all();
        };


        $this->data->item_detil = function ($ide_kode) {
            return $this->item_detil
                ->with_item()
                ->with_warna('order_by:w_nama')
                ->with_ukuran('order_by:u_nama')
                ->with_seri()
                ->with_item_img()
                ->where_item_detil_kode($ide_kode)
                ->get();
        };

        $this->data->item_detil_all = function ($ide_kode) {
            return $this->item_detil
                ->with_item()
                ->with_warna('order_by:w_nama')
                ->with_ukuran('order_by:u_nama')
                ->with_seri()
                ->with_item_img()
                ->where_item_detil_kode($ide_kode)
                ->get_all();
        };

        $this->data->warna = function ($i_kode) {
            return $this->warna
                ->with_item_detil('where:i_kode = \'' . $i_kode . '\'')
                ->get_all();
        };

        $this->data->ukuran = function ($i_kode) {
            return $this->ukuran
                ->with_item_detil('where:i_kode = \'' . $i_kode . '\'')
                ->get_all();
        };

        $this->data->qty = function ($i_kode) {
            $hasil = 0;
            $stoks = $this->item_qty->fields('iq_qty')->with_item_detil('where:i_kode = \'' . $i_kode . '\'')->get_all();
            foreach ($stoks as $stok) {
                $hasil += $stok->iq_qty;
            }

            return $hasil;
        };

        $this->data->qty_detil = function ($ide_kode) {
            $hasil = 0;
            $stoks = $this->item_qty->fields('iq_qty')->where_item_detil_kode($ide_kode)->get_all();
            foreach ($stoks as $stok) {
                $hasil += $stok->iq_qty;
            }

            return $hasil;
        };

        $this->data->item_img = function ($i_kode) {
            return $this->item_img
                ->where(array('i_kode' => $i_kode, 'ii_default' => 1))
                ->get();
        };

        $this->data->item_img_all = function ($i_kode) {
            return $this->item_img->where(array('i_kode' => $i_kode))->get_all();
        };

        $this->data->cart_s = function ($p_kode) {
            return $this->cart->where_pengguna_kode($p_kode)->get_all();
        };

        $this->data->cart_total = function ($p_kode) {
            $hasil = 0;
            foreach ($this->cart->where_pengguna_kode($p_kode)->get_all() as $cart_total) {
                $hasil += (int)$cart_total->ca_tharga;
            }

            return $hasil;
        };

        $this->data->bank_s = function () {
            return $this->bank->get_all();
        };
    }

    private function load_pref()
    {
        $toko = $this->toko->get();
        if ($toko) {
            $this->data->brandname = $toko->t_nama;
            $this->data->brandkode = $toko->t_singkatan;
            $this->data->email = $toko->t_email;
            $this->data->whatsapp = $toko->t_wa;
            $this->data->logo = $toko->t_logo;
            $this->data->icon = $toko->t_icon;
        } else {
            $this->data->brandname = 'E-Commerce Brand';
            $this->data->brandkode = 'EB';
            $this->data->email = '';
            $this->data->whatsapp = '';

            $this->data->logo = '';
            $this->data->icon = '';


        }


    }

}

