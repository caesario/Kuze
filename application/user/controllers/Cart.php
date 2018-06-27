<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isonline) {
            redirect('login');
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'GET')
            {
                $this->session->set_userdata('redirect', current_url());
            }
        }
    }

    public function index()
    {
        $this->load->view('Cart', $this->data);

    }

    public function modal_cart()
    {
        $this->load->view('Modal_Cart', $this->data);
    }

    public function add()
    {
        $ide_kode = $this->input->post('wu');
        $this->data->item = $this->item_detil->with_item()->where_item_detil_kode($ide_kode)->get();

        $cart = $this->cart->where_item_detil_kode($ide_kode)->get();
        if ($cart) {
            $qty_exist = (int)$cart->ca_qty;
            $qty_new = (int)$this->input->post('qty');

            $cart_update = $this->cart->where_item_detil_kode($ide_kode)->update(array(
                'ca_qty' => $qty_exist + $qty_new,
                'ca_harga' => (int)$this->input->post('harga'),
                'ca_tharga' => ((int)$cart->ca_qty + (int)$this->input->post('qty')) * (int)$this->input->post('harga'),
                'pengguna_kode' => $_SESSION['id']
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
                redirect('/');
            }
        } else {
            $cart_insert = $this->cart->insert(array(
                'ca_kode' => $this->cart->guid(),
                'ca_qty' => (int)$this->input->post('qty'),
                'ca_harga' => (int)$this->input->post('harga'),
                'ca_tharga' => (int)$this->input->post('qty') * (int)$this->input->post('harga'),
                'item_detil_kode' => $ide_kode,
                'pengguna_kode' => $_SESSION['id']
            ));

            $item_qty_update = $this->item_qty->insert(array(
                'iq_kode' => $this->item_qty->guid(),
                'iq_qty' => -(int)$this->input->post('qty'),
                'item_detil_kode' => $ide_kode
            ));

            if ($cart_insert && $item_qty_update) {
                $this->data->berhasil = 'Berhasil menambah item kedalam keranjang';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);
                $this->session->set_flashdata('modal', '1');
                redirect('/');
            }
        }
    }

    public function checkout()
    {
        $p_kode = $_SESSION['id'];
        $carts = $this->cart->where_pengguna_kode($p_kode)->get_all();
        $noid = date('ymd') . (int)$this->order->count_rows() + 1;

        if ($carts) {

            $this->order->insert(array(
                'orders_noid' => $noid,
                'pengguna_kode' => $p_kode
            ));

            foreach ($carts as $cart) {
                $this->order_detil->insert(array(
                    'orders_detil_qty' => (int)$cart->ca_qty,
                    'orders_detil_harga' => (int)$cart->ca_harga,
                    'orders_detil_tharga' => (int)$cart->ca_tharga,
                    'orders_noid' => $noid,
                    'item_detil_kode' => $cart->item_detil_kode
                ));

            }
            $this->cart->where_pengguna_kode($p_kode)->delete();
            redirect('checkout/' . $noid . '/alamat_pengiriman');
        } else {
            $this->data->gagal = 'Tidak ada item didalam keranjang.';
            $this->session->set_flashdata('gagal', $this->data->gagal);
            redirect('cart');
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

                redirect('cart');
            } else {
                $this->data->gagal = 'Item gagal dihapus.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('cart');
            }
        }

    }

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */