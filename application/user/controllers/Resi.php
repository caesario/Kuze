<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resi extends MY_Controller
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
        $pengiriman = function ($orders_noid) {
            $hasil = new stdClass();
            $order_pengiriman = $this->order_pengiriman->where('orders_noid', $orders_noid)->get();
            if ($order_pengiriman == NULL) {
                return 'YOU NEED TO FILL THE ADDRESS';
            } else {
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
            }


        };

        $data = function () use ($pengiriman) {
            $resis = $this->order->with_order_resi()->with_order_pengiriman()->get_all();

            if ($resis) {
                foreach ($resis as $resi) {
                    if (isset($resi->order_pengiriman)) {
                        $resi->order_pengiriman = $pengiriman($resi->orders_noid);
                    } else {
                        $resi->order_pengiriman = 'NULL';
                    }

                    if (isset($resi->order_resi)) {
                        $resi->order_resi = $resi->order_resi->orders_resi_no;
                    } else {
                        $resi->order_resi = 'NULL';
                    }
                }
            }

            return $resis;
        };

        $this->data->resis = $data();

        $this->load->view('Resi', $this->data);
//        echo '<pre>';
//        var_dump($data());
//        echo '</pre>';
    }

    public function get($id)
    {
        $this->data->resi = $this->order_resi->where('orders_resi_no', $id)->get();
        $this->load->view('Resi_detil', $this->data);

    }

    public function tracking($orders_noid)
    {
        $this->load->library('RajaOngkir');
        $resi = $this->order_resi->where('orders_noid', $orders_noid)->get();

        if ($resi) {
            $airwaybill = $resi->orders_resi_no;
            $courier = $resi->orders_resi_unik;

            $result = $this->rajaongkir->waybill($airwaybill, $courier);

            $this->load->view('Result_resi', $result);
        }
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */