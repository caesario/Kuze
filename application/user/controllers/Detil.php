<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detil extends MY_Controller
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
        $orders_noid = $this->uri->segment(2);
        $this->data->orders_noid = $orders_noid;
        $this->data->orders = $this->order->with_order_detil()->where_orders_noid($orders_noid)->get();
        $this->data->orders_total = function () {
            $hasil = 0;
            foreach ($this->data->orders->order_detil as $order) {
                $hasil += $order->orders_detil_tharga;
            }
            return $hasil;
        };

        $promo = function () use ($orders_noid) {
            $promo_kode = $this->order->where('orders_noid', $orders_noid)->get()->promo_kode;
            return $this->promo->where('promo_kode', $promo_kode)->get();
        };


        $pengiriman = function () use ($orders_noid) {
            $hasil = new stdClass();
            $order_pengiriman = $this->order_pengiriman->where('orders_noid', $orders_noid)->get();
            $hasil->provinsi = $this->provinsi
                ->where('provinsi_id', $order_pengiriman->orders_pengiriman_provinsi)
                ->get()->provinsi_nama;
            $hasil->kabupaten = $this->kabupaten
                ->where('kabupaten_id', $order_pengiriman->orders_pengiriman_kabupaten)
                ->get()->kabupaten_nama;
            $hasil->kecamatan = $this->kecamatan
                ->where('kecamatan_id', $order_pengiriman->orders_pengiriman_kecamatan)
                ->get()->kecamatan_nama;


            return $order_pengiriman->orders_pengiriman_deskripsi . '<br>' . $hasil->kecamatan . ', ' . $hasil->kabupaten . '<br>' .
                $hasil->provinsi . ', ' . $order_pengiriman->orders_pengiriman_kodepos;

        };

        $nama_nomor = function () use ($orders_noid) {
            $order_pengiriman = $this->order_pengiriman->where('orders_noid', $orders_noid)->get();
            $hasil = new stdClass();
            $hasil->nama = $order_pengiriman->orders_pengiriman_r_nama;
            $hasil->kontak = $order_pengiriman->orders_pengiriman_r_kontak;

            return $hasil->nama . '<br>' . $hasil->kontak;
        };

        $jasa = function () use ($orders_noid) {
            $ongkir = $this->order_ongkir->where('orders_noid', $orders_noid)->get();

            return $ongkir->orders_ongkir_nama . ' - ' . $ongkir->orders_ongkir_deskripsi . ' (' . $ongkir->orders_ongkir_estimasi . ' hari)';
        };

        $metode_pembayaran = function () use ($orders_noid) {
            $pembayaran = $this->order_payment->with_bank()->where('orders_noid', $orders_noid)->get()->bank;

            return $pembayaran->bank_penerbit . ' - (A/N: ' . $pembayaran->bank_nama . ') (Nomor Rek: ' . $pembayaran->bank_rek . ')';
        };

        $biaya_subtotal = function () use ($orders_noid) {
            $hasil = 0;
            foreach ($this->order_detil->where('orders_noid', $orders_noid)->get_all() as $od) {
                $hasil += (int)$od->orders_detil_tharga;
            }

            return $hasil;
        };

        $biaya_pengiriman = function () use ($orders_noid) {
            $ongkir = $this->order_ongkir->where('orders_noid', $orders_noid)->get();
            return (int)$ongkir->orders_ongkir_biaya;
        };

        if ($this->data->orders->orders_status == 7) {
            $this->data->gagal = 'Order tidak ada atau telah dibatalkan.';
            $this->session->set_flashdata('gagal', $this->data->gagal);
            redirect('/');
        }

        $grand_total = function () use ($biaya_subtotal, $promo, $biaya_pengiriman) {

            $harga = $biaya_subtotal();
            $diskon = $promo();
            if ($diskon) {
                $promo_rate = $diskon->promo_rate;
                $promo_nominal = $diskon->promo_nominal;
            } else {
                $promo_rate = 0;
                $promo_nominal = 0;
            }


            if ($promo_rate != 0) {
                $potongan = $harga * ($promo_rate / 100);
                $hasil = $harga - $potongan;

            } elseif ($promo_nominal != 0) {
                $potongan = $promo_nominal;
                $hasil = $harga - $potongan;
            } else {
                $hasil = $harga;
            }

            $hasil = $hasil + $biaya_pengiriman();

            return $hasil;
        };

        $diskon_harga = function () use ($biaya_subtotal, $promo) {
            $harga = $biaya_subtotal();
            $diskon = $promo();
            if ($diskon) {
                $promo_rate = $diskon->promo_rate;
                $promo_nominal = $diskon->promo_nominal;
            } else {
                $promo_rate = 0;
                $promo_nominal = 0;
            }

            if ($promo_rate != 0) {
                $potongan = $harga * ($promo_rate / 100);
                $hasil = $potongan;
            } elseif ($promo_nominal != 0) {
                $hasil = $promo_nominal;
            } else {
                $hasil = 0;
            }

            return $hasil;
        };

        $this->data->promo = $promo();
        $this->data->pengiriman = $pengiriman();
        $this->data->nama_nomor = $nama_nomor();
        $this->data->jasa = $jasa();
        $this->data->metode_pembayaran = $metode_pembayaran();
        $this->data->biaya_pengiriman = $biaya_pengiriman();
        $this->data->biaya_subtotal = $biaya_subtotal();
        $this->data->diskon_harga = $diskon_harga();
        $this->data->grand_total = $grand_total();

        $this->data->breadcumurl1 = site_url($this->uri->segment(1));
        $this->data->breadcumurl2 = site_url($this->uri->segment(2));
        $this->data->breadcum1 = $this->uri->segment(1);
        $this->data->breadcum2 = $this->uri->segment(2);
        $this->load->view('DetailPesanan', $this->data);
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */