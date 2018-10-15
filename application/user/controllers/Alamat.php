<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alamat extends MY_Controller
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
        $this->load->view('Alamat', $this->data);

    }

    public function get($order)
    {

        $this->data->alamat_kode = $this->alamat->guid();
        $this->data->nomor_order = $order;
        $this->data->orders = $this->order->with_order_detil()->where_orders_noid($order)->get();
        $this->data->orders_total = function () {
            $hasil = 0;
            foreach ($this->data->orders->order_detil as $order) {
                $hasil += $order->orders_detil_tharga;
            }
            return $hasil;
        };

        if ($this->data->orders->orders_status == 7) {
            $this->data->gagal = 'Order tidak ada atau telah dibatalkan.';
            $this->session->set_flashdata('gagal', $this->data->gagal);
            redirect('/');
        }
        $this->load->view('Alamat', $this->data);
    }

    public function simpan()
    {
        $alamat_exist = $this->input->post('alamat_exist');
        $alamat_simpan = $this->input->post('alamat_simpan');

        $orders_noid = $this->uri->segment(2);

        // sender and receiver
        $nama_pengirim = $this->input->post('nama_pengirim');
        $kontak_pengirim = $this->input->post('kontak_pengirim');
        $nama_penerima = $this->input->post('nama_penerima');
        $kontak_penerima = $this->input->post('kontak_penerima');


        $order_pengiriman = $this->order_pengiriman->where('orders_noid', $orders_noid)->get();

        if ($order_pengiriman) {
            $this->order_pengiriman->where('orders_noid', $orders_noid)->update(array(
                'orders_pengiriman_s_nama' => $nama_pengirim,
                'orders_pengiriman_s_kontak' => $kontak_pengirim,
                'orders_pengiriman_r_nama' => $nama_penerima,
                'orders_pengiriman_r_kontak' => $kontak_penerima,
                'orders_pengiriman_provinsi' => $this->input->post('provinsi'),
                'orders_pengiriman_kabupaten' => $this->input->post('kabupaten'),
                'orders_pengiriman_kecamatan' => $this->input->post('kecamatan'),
                'orders_pengiriman_desa' => $this->input->post('kelurahan'),
                'orders_pengiriman_kodepos' => $this->input->post('kodepos'),
                'orders_pengiriman_deskripsi' => $this->input->post('alamat')
            ));
        } else {
            $this->order_pengiriman->insert(array(
                'orders_noid' => $orders_noid,
                'orders_pengiriman_s_nama' => $nama_pengirim,
                'orders_pengiriman_s_kontak' => $kontak_pengirim,
                'orders_pengiriman_r_nama' => $nama_penerima,
                'orders_pengiriman_r_kontak' => $kontak_penerima,
                'orders_pengiriman_provinsi' => $this->input->post('provinsi'),
                'orders_pengiriman_kabupaten' => $this->input->post('kabupaten'),
                'orders_pengiriman_kecamatan' => $this->input->post('kecamatan'),
                'orders_pengiriman_desa' => $this->input->post('kelurahan'),
                'orders_pengiriman_kodepos' => $this->input->post('kodepos'),
                'orders_pengiriman_deskripsi' => $this->input->post('alamat')
            ));
        }


        $this->order->where('orders_noid', $orders_noid)->update(array('orders_status' => 1));


        if ($alamat_simpan == 'true') {
            // GUID
            $guid = $this->alamat->guid();
            $alamat = $this->alamat->insert(array(
                'alamat_kode' => $guid,
                'alamat_provinsi' => $this->input->post('provinsi'),
                'alamat_kabupaten' => $this->input->post('kabupaten'),
                'alamat_kecamatan' => $this->input->post('kecamatan'),
                'alamat_desa' => $this->input->post('kelurahan'),
                'alamat_kodepos' => $this->input->post('kodepos'),
                'alamat_deskripsi' => $this->input->post('alamat')
            ));

            if ($alamat) {
                $this->pengguna_alamat->insert(array(
                    'pengguna_alamat_kode' => $this->pengguna_alamat->guid(),
                    'pengguna_alamat_s_nama' => $nama_pengirim,
                    'pengguna_alamat_s_kontak' => $kontak_pengirim,
                    'pengguna_alamat_r_nama' => $nama_penerima,
                    'pengguna_alamat_r_kontak' => $kontak_penerima,
                    'pengguna_kode' => $_SESSION['id'],
                    'alamat_kode' => $guid,
                ));
            }
        }

        redirect('checkout/' . $orders_noid . '/ongkir_transfer');
    }
}