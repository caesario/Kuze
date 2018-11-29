<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bag extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isonline) {
            redirect('login');
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $this->session->set_userdata('redirect', current_url());
            }
        }
    }

    public function index()
    {
        $this->load->view('Bag', $this->data);

    }

    public function modal_bag()
    {
        $this->data->cart_total = function () {
            $hasil = 0;
            foreach ($this->cart->where('pengguna_kode', $_SESSION['id'])->get_all() as $cart_total) {
                $hasil += (int)$cart_total->ca_tharga;
            }

            return $hasil;
        };

        $this->load->view('Modal_Bag', $this->data);
    }

    public function add()
    {
        $item_kode = $this->input->post('item');
        $item_ukuran_kode = $this->input->post('ukuran');
        $item_detil_kode = $this->input->post('detil');


        $this->data->item = $this->item_detil->with_item()->where_item_detil_kode($item_detil_kode)->get();

        $cart = $this->cart->where_item_detil_kode($item_detil_kode)->get();
        if ($cart) {
            $qty_exist = (int)$cart->ca_qty;
            $qty_new = (int)$this->input->post('qty');

            $cart_update = $this->cart->where_item_detil_kode($item_detil_kode)->update(array(
                'ca_qty' => $qty_exist + $qty_new,
                'ca_harga' => (int)$this->input->post('harga'),
                'ca_tharga' => ((int)$cart->ca_qty + (int)$this->input->post('qty')) * (int)$this->input->post('harga'),
                'pengguna_kode' => $_SESSION['id'],
                'item_detil_kode' => $item_detil_kode,
                'item_ukuran_kode' => $item_ukuran_kode,
                'item_kode' => $item_kode

            ));

            $qty_exist = -1 * abs($qty_exist);
            $qty_new = -1 * abs($qty_new);

            $item_qty_update = $this->item_qty->insert(array(
                'iq_kode' => $this->item_qty->guid(),
                'iq_qty' => $qty_new,
                'item_detil_kode' => $cart->item_detil_kode
            ));

            if ($cart_update && $item_qty_update) {
                $this->data->berhasil = 'Berhasil menambah item kedalam keranjang';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);
                $this->session->set_flashdata('modal', '1');
            }
        } else {
            $cart_insert = $this->cart->insert(array(
                'ca_kode' => $this->cart->guid(),
                'ca_qty' => (int)$this->input->post('qty'),
                'ca_harga' => (int)$this->input->post('harga'),
                'ca_tharga' => (int)$this->input->post('qty') * (int)$this->input->post('harga'),
                'pengguna_kode' => $_SESSION['id'],
                'item_detil_kode' => $item_detil_kode,
                'item_ukuran_kode' => $item_ukuran_kode,
                'item_kode' => $item_kode
            ));

            $item_qty_update = $this->item_qty->insert(array(
                'iq_kode' => $this->item_qty->guid(),
                'iq_qty' => -(int)$this->input->post('qty'),
                'item_detil_kode' => $item_detil_kode
            ));

            if ($cart_insert && $item_qty_update) {
                $this->data->berhasil = 'Berhasil menambah item kedalam keranjang';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);
                $this->session->set_flashdata('modal', '1');
            }
        }


        if (isset($_SESSION['current_url'])) {
            redirect($_SESSION['current_url']);
        } else {
            redirect('/');
        }
    }

    public function checkout()
    {
        $pengguna_kode = $_SESSION['id'];
        $carts = $this->cart->where_pengguna_kode($pengguna_kode)->get_all();
        $nomor_order = date('ymd') . mt_rand(100, 999);
        $cart_total = function () {
            $hasil = 0;
            foreach ($this->cart->where('pengguna_kode', $_SESSION['id'])->get_all() as $cart_total) {
                $hasil += (int)$cart_total->ca_tharga;
            }

            return (int)$hasil;
        };

        if ($carts) {

            $promo_kode = 0;
            $harga = $cart_total();
            $totalharga = $harga;
            $this->order->insert(array(
                'orders_noid' => $nomor_order,
                'pengguna_kode' => $pengguna_kode,
                'orders_hrg' => $harga,
                'promo_kode' => $promo_kode,
                'orders_thrg' => $totalharga,
                'orders_uniq' => mt_rand(100, 399)
            ));

            foreach ($carts as $cart) {
                $this->order_detil->insert(array(
                    'orders_detil_qty' => (int)$cart->ca_qty,
                    'orders_detil_harga' => (int)$cart->ca_harga,
                    'orders_detil_tharga' => (int)$cart->ca_tharga,
                    'orders_noid' => $nomor_order,
                    'item_kode' => $cart->item_kode,
                    'item_detil_kode' => $cart->item_detil_kode,
                    'item_ukuran_kode' => $cart->item_ukuran_kode

                ));

            }
            $this->cart->where_pengguna_kode($pengguna_kode)->delete();
            redirect('checkout/' . $nomor_order . '/alamat_pengiriman');
        } else {
            $this->data->gagal = 'Tidak ada item didalam keranjang.';
            $this->session->set_flashdata('gagal', $this->data->gagal);
            redirect('bag');
        }


    }

    public function checkout_with_promo($kodepromo)
    {
        $pengguna_kode = $_SESSION['id'];
        $carts = $this->cart->where_pengguna_kode($pengguna_kode)->get_all();
        $nomor_order = date('ymd') . mt_rand(100, 999);
        $cart_total = function () {
            $hasil = 0;
            foreach ($this->cart->where('pengguna_kode', $_SESSION['id'])->get_all() as $cart_total) {
                $hasil += (int)$cart_total->ca_tharga;
            }

            return (int)$hasil;
        };

        if ($carts) {
            if (isset($kodepromo) && $kodepromo != NULL) {
                $promo = $this->promo->where('promo_nama', $kodepromo)->get();
                $promo_kode = $promo->promo_kode;

                $harga = $cart_total();
                $promo_rate = $promo->promo_rate;
                $promo_nominal = $promo->promo_nominal;

                if ($promo_rate != 0) {
                    $potongan = $harga * ($promo_rate / 100);
                    $totalharga = $harga - $potongan;

                } elseif ($promo_nominal != 0) {
                    $potongan = $promo_nominal;
                    $totalharga = $harga - $potongan;
                } else {
                    $totalharga = $harga;
                }
            } else {
                $promo_kode = 0;
                $harga = $cart_total();
                $totalharga = $harga;
            }

            $this->order->insert(array(
                'orders_noid' => $nomor_order,
                'pengguna_kode' => $pengguna_kode,
                'orders_hrg' => $harga,
                'promo_kode' => $promo_kode,
                'orders_thrg' => $totalharga,
                'orders_uniq' => mt_rand(100, 399)
            ));

            foreach ($carts as $cart) {
                $this->order_detil->insert(array(
                    'orders_detil_qty' => (int)$cart->ca_qty,
                    'orders_detil_harga' => (int)$cart->ca_harga,
                    'orders_detil_tharga' => (int)$cart->ca_tharga,
                    'orders_noid' => $nomor_order,
                    'item_kode' => $cart->item_kode,
                    'item_detil_kode' => $cart->item_detil_kode,
                    'item_ukuran_kode' => $cart->item_ukuran_kode

                ));

            }
            $this->cart->where_pengguna_kode($pengguna_kode)->delete();
            redirect('checkout/' . $nomor_order . '/alamat_pengiriman');
        } else {
            $this->data->gagal = 'Tidak ada item didalam keranjang.';
            $this->session->set_flashdata('gagal', $this->data->gagal);
            redirect('bag');
        }


    }

    public function delete($ca_kode)
    {
        $cart = $this->cart->where_ca_kode($ca_kode)->get();

        if ($cart) {

            $item_qty_update = $this->item_qty->insert(array(
                'iq_kode' => $this->item_qty->guid(),
                'iq_qty' => $cart->ca_qty,
                'item_detil_kode' => $cart->item_detil_kode
            ));

            $cart_delete = $this->cart->where_ca_kode($ca_kode)->delete();
            if ($item_qty_update && $cart_delete) {
                $this->data->berhasil = 'Item berhasil dihapus.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('bag');
            } else {
                $this->data->gagal = 'Item gagal dihapus.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('bag');
            }
        }

    }


}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */