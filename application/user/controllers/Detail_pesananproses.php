<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_pesananproses extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isonline) {
            redirect('login');
        }
    }

    public function index()
    {
        $this->data->orders_noid = $this->uri->segment(2);
        $this->data->orders = $this->order->with_order_detil()->where_orders_noid($this->data->orders_noid)->get();
        $this->data->orders_total = function () {
            $hasil = 0;
            foreach ($this->data->orders->order_detil as $order) {
                $hasil += $order->orders_detil_tharga;
            }
            return $hasil;
        };
        $this->data->pengiriman = function () {
            $alamat = new stdClass();
            $order_pengiriman = $this->order_pengiriman->where('orders_noid', $this->data->orders_noid)->get();

            if ($order_pengiriman) {
                $alamat->provinsi = $this->provinsi
                    ->where('provinsi_id', $order_pengiriman->orders_pengiriman_provinsi)
                    ->get()->provinsi_nama;
                $alamat->kabupaten = $this->kabupaten
                    ->where('kabupaten_id', $order_pengiriman->orders_pengiriman_kabupaten)
                    ->get()->kabupaten_nama;
                $alamat->kecamatan = $this->kecamatan
                    ->where('kecamatan_id', $order_pengiriman->orders_pengiriman_kecamatan)
                    ->get()->kecamatan_nama;
                $alamat->desa = $this->desa
                    ->where('desa_id', $order_pengiriman->orders_pengiriman_desa)
                    ->get()->desa_nama;
                $hasil = $order_pengiriman->orders_pengiriman_deskripsi . '<br>' . $alamat->desa . '<br>' . $alamat->kecamatan . ', ' . $alamat->kabupaten . '<br>' .
                    $alamat->provinsi . ', ' . $order_pengiriman->orders_pengiriman_kodepos;
            } else {
                $hasil = '';
            }
            return $hasil;

        };

        $this->data->jasa = function () {
            $ongkir = $this->order_ongkir->where('orders_noid', $this->data->orders_noid)->get();

            return $ongkir->orders_ongkir_nama . ' - ' . $ongkir->orders_ongkir_deskripsi . ' (' . $ongkir->orders_ongkir_estimasi . ' hari)';
        };

        $this->data->metode_pembayaran = function () {
            $orders_noid = $this->order
                ->where('orders_noid', $this->data->orders_noid)
                ->get()->orders_noid;
            $pembayaran = $this->order_payment->with_bank()->where('orders_noid', $orders_noid)->get();

            if ($pembayaran) {
                $hasil = $pembayaran->bank->bank_penerbit . ' - (A/N: ' . $pembayaran->bank->bank_nama . ') (Nomor Rek: ' . $pembayaran->bank->bank_rek . ')';

            } else {
                $hasil = '';
            }

            return $hasil;
        };

        $this->data->biaya_subtotal = function () {
            $hasil = 0;
            $orders_noid = $this->order
                ->where('orders_noid', $this->data->orders_noid)
                ->get()->orders_noid;
            foreach ($this->order_detil->where('orders_noid', $orders_noid)->get_all() as $od) {
                $hasil += (int)$od->orders_detil_tharga;
            }

            return $hasil;
        };

        $this->data->biaya_pengiriman = function () {
            $orders_noid = $this->order
                ->where('orders_noid', $this->data->orders_noid)
                ->get()->orders_noid;
            $ongkir = $this->order_ongkir->where('orders_noid', $orders_noid)->get();

            if ($ongkir) {
                return (int)$ongkir->orders_ongkir_biaya;
            } else {
                return 0;
            }

        };
        $this->data->nama_nomor = function () {
            $order_pengiriman = $this->order_pengiriman->where('orders_noid', $this->data->orders_noid)->get();
            $hasil = new stdClass();
            $hasil->nama = $order_pengiriman->orders_pengiriman_r_nama;
            $hasil->kontak = $order_pengiriman->orders_pengiriman_r_kontak;

            return $hasil->nama . '<br>' . $hasil->kontak;
        };

        $this->data->breadcumurl1 = site_url($this->uri->segment(1));
        $this->data->breadcumurl2 = site_url($this->uri->segment(2));
        $this->data->breadcum1 = $this->uri->segment(1);
        $this->data->breadcum2 = $this->uri->segment(2);
        $this->load->view('Detail_pesananproses', $this->data);
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */