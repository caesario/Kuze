<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ongkir_transfer extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isonline) {
            redirect('login');
        }

        $this->load->library('Ongkir', 'ongkir');
    }

    public function index()
    {
        $this->load->view('Ongkir_transfer', $this->data);

    }

    public function get($order)
    {
        $this->data->nomor_order = $order;
        $this->data->orders = $this->order->with_order_detil()->where_orders_noid($order)->get();
        $this->data->orders_total = function () {
            $hasil = 0;
            foreach ($this->data->orders->order_detil as $order) {
                $hasil += $order->orders_detil_tharga;
            }
            return $hasil;
        };

        $this->data->bank_opsi = function () {
            $bank = $this->bank->get();
            if ($bank) {
                $hasil = true;
            } else {
                $hasil = false;
            }

            return $hasil;
        };

        $this->data->pengiriman = $this->get_biaya($order)->rajaongkir->results;

        if ($this->data->orders->orders_status == 7) {
            $this->data->gagal = 'Order tidak ada atau telah dibatalkan.';
            $this->session->set_flashdata('gagal', $this->data->gagal);
            redirect('/');
        }

        $this->load->view('Ongkir_transfer', $this->data);
    }

    private function get_biaya($orders_noid)
    {
        $hasil = new stdClass();
        $order_pengiriman = $this->order_pengiriman->where('orders_noid', $orders_noid)->get();
        $dst_id = $order_pengiriman->orders_pengiriman_kabupaten;
        $ori_id = $this->toko->get()->t_kabupaten;
        $dst = (string)$this->kabupaten->where('kabupaten_id', $dst_id)->get()->kabupaten_nama;
        $origin = (string)$this->kabupaten->where('kabupaten_id', $ori_id)->get()->kabupaten_nama;

        $ongkir = json_decode($this->ongkir->city(), true);
        $ongkir = $ongkir['rajaongkir']['results'];

        foreach ($ongkir as $key => $value) {

            if (strpos($dst, (string)$ongkir[$key]['city_name'])) {
                $hasil->dst_id = $ongkir[$key]['city_id'];
                $hasil->dst_name = $ongkir[$key]['city_name'];
            }

            if (strpos($origin, (string)$ongkir[$key]['city_name'])) {
                $hasil->origin_id = $ongkir[$key]['city_id'];
                $hasil->origin_name = $ongkir[$key]['city_name'];
            }

        }

        $cost = $this->ongkir->cost($hasil->origin_id, $hasil->dst_id, $this->get_berat($orders_noid), "jne");
        echo '<script>console.log(' . $cost . ')</script>';
        return json_decode($cost);
    }

    private function get_berat($orders_noid)
    {
        $orders = $this->order->with_order_detil()->where('orders_noid', $orders_noid)->get();
        foreach ($orders->order_detil as $detil) {
            $item_berat = (int)$this->item_detil->with_item()->where('item_detil_kode', $detil->item_detil_kode)->get()->item->i_berat;
            $item_qty = (int)$detil->orders_detil_qty;

            $hasil = $item_berat * $item_qty;
        }

        if ($hasil > 2899) {
            return $hasil = 2899;
        } else {
            return $hasil;
        }

    }

    public function simpan()
    {
        $orders_noid = $this->input->post('nomor_order');

        $order_ongkir = $this->order_ongkir->where('orders_noid', $orders_noid)->get();
        $order_payment = $this->order_payment->where('orders_noid', $orders_noid)->get();

        if ($order_ongkir && $order_payment) {
            $this->order_ongkir->where('orders_noid', $orders_noid)->update(array(
                'orders_ongkir_nama' => $this->input->post('nama'),
                'orders_ongkir_deskripsi' => $this->input->post('deskripsi'),
                'orders_ongkir_estimasi' => $this->input->post('estimasi'),
                'orders_ongkir_biaya' => $this->input->post('biaya')
            ));

            $this->order_payment->where('orders_noid', $orders_noid)->update(array(
                'bank_kode' => $this->input->post('bank_id')
            ));

            $this->order->where('orders_noid', $orders_noid)->update(array('orders_status' => 2));
        } else {
            $this->order_ongkir->insert(array(
                'orders_ongkir_nama' => $this->input->post('nama'),
                'orders_ongkir_deskripsi' => $this->input->post('deskripsi'),
                'orders_ongkir_estimasi' => $this->input->post('estimasi'),
                'orders_ongkir_biaya' => $this->input->post('biaya'),
                'orders_noid' => $orders_noid
            ));

            $this->order_payment->insert(array(
                'orders_noid' => $orders_noid,
                'bank_kode' => $this->input->post('bank_id')

            ));
            $this->order->where('orders_noid', $orders_noid)->update(array('orders_status' => 2));
        }

        redirect('checkout/' . $orders_noid . '/konfirmasi_pembayaran');
    }

}