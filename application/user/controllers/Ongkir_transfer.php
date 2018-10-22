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

        $this->load->library('RajaOngkir', 'ongkir');
    }

    public function index()
    {
        $this->load->view('Ongkir_transfer', $this->data);

    }

    public function get($order)
    {
        $data_check = array(
            'orders_noid' => $order,
            'orders_status' => 1
        );

        if ($this->order->where($data_check)->get()) {
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
        } else {
            $this->data->gagal = 'Mohon maaf anda belum mengisi alamat pengiriman';
            $this->session->set_flashdata('gagal', $this->data->gagal);
            redirect('checkout/' . $order . '/alamat_pengiriman');
        }

    }

    private function get_biaya($orders_noid, $kurir = 'jne:sicepat:jnt')
    {
        $order_pengiriman = $this->order_pengiriman->where('orders_noid', $orders_noid)->get();
        $dst_id = $order_pengiriman->orders_pengiriman_kecamatan;
        $ori_id = $this->toko->get()->t_kecamatan;

        $cost = $this->rajaongkir->cost($ori_id, 'subdistrict', $dst_id, 'subdistrict', $this->get_berat($orders_noid), $kurir);
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
        $data_check = array(
            'orders_noid' => $orders_noid,
            'orders_status' => 1
        );

        if ($this->order->where($data_check)->get()) {
            try {
                $data_ongkir = array(
                    'orders_noid' => $orders_noid,
                    'orders_ongkir_nama' => $this->input->post('nama'),
                    'orders_ongkir_deskripsi' => $this->input->post('deskripsi'),
                    'orders_ongkir_estimasi' => $this->input->post('estimasi'),
                    'orders_ongkir_biaya' => $this->input->post('biaya')

                );

                $data_payment = array(
                    'orders_noid' => $orders_noid,
                    'bank_kode' => $this->input->post('bank_id')

                );

                $order_ongkir = $this->order_ongkir->where('orders_noid', $orders_noid)->get();
                $order_payment = $this->order_payment->where('orders_noid', $orders_noid)->get();

                if ($order_ongkir) {
                    $this->order_ongkir->update($data_ongkir, 'orders_noid');
                } else {
                    $this->order_ongkir->insert($data_ongkir);
                }

                if ($order_payment) {
                    $this->order_payment->update($data_payment, 'orders_noid');
                } else {
                    $this->order_payment->insert($data_payment);
                }

                $data_update = array(
                    'orders_noid' => $orders_noid,
                    'orders_status' => 2
                );

                $this->order->update($data_update, 'orders_noid');
                redirect('checkout/' . $orders_noid . '/konfirmasi_pembayaran');
            } catch (Exception $e) {
                $this->data->gagal = 'Gagal mengisi metode pengiriman & pembayaran.';
                $this->session->set_flashdata('gagal', $this->data->gagal);
            }

        } else {
            $this->data->gagal = 'Mohon maaf anda belum mengisi alamat pengiriman';
            $this->session->set_flashdata('gagal', $this->data->gagal);
            redirect('checkout/' . $orders_noid . '/alamat_pengiriman');
        }
    }

}