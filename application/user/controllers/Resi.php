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
            $result = json_decode($result, true);
            $result = $result['rajaongkir'];

            $page = array();
            $page['query_name'] = $result['query']['waybill'] . ' (' . strtoupper($result['query']['courier']) . ')';
            $page['waybill_number'] = $result['result']['summary']['waybill_number'];
            $page['service_code'] = $result['result']['summary']['service_code'];
            $page['shipper_name'] = $result['result']['summary']['shipper_name'];
            $page['receiver_name'] = $result['result']['summary']['receiver_name'];
            $page['waybill_datetime'] = $result['result']['details']['waybill_date'] . ' ' . $result['result']['details']['waybill_time'];
            $page['weight'] = $result['result']['details']['weight'];
            $page['shipper_city'] = $result['result']['details']['shipper_city'];
            $page['address'] = $result['result']['details']['receiver_address1'] . ',';
            $page['address'] = $page['address'] . $result['result']['details']['receiver_address2'] . ' , ';
            $page['address'] = $page['address'] . $result['result']['details']['receiver_address3'] . ' , ';
            $page['address'] = $page['address'] . $result['result']['details']['receiver_city'];
            $page['status'] = $result['result']['delivery_status']['status'];
            $page['pod_receiver'] = $result['result']['delivery_status']['pod_receiver'];
            $page['pod_datetime'] = $result['result']['delivery_status']['pod_date'] . ' ';
            $page['pod_datetime'] = $page['pod_datetime'] . $result['result']['delivery_status']['pod_time'];
            $page['manifests'] = $result['result']['manifest'];

            $this->load->view('Result_resi', $page);
        }
    }

    public function tracking2($orders_noid)
    {
        $this->load->library('RajaOngkir');
        $resi = $this->order_resi->where('orders_noid', $orders_noid)->get();

        if ($resi) {
            $airwaybill = $resi->orders_resi_no;
            $courier = $resi->orders_resi_unik;

            $result = $this->rajaongkir->waybill($airwaybill, $courier);
            $result = json_decode($result, true);
            $result = $result['rajaongkir'];
//            $this->load->view('Result_resi', $result);
            echo '<pre>';
            var_dump($result);
            echo '</pre>';
        }
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */