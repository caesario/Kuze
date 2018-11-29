<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Resi extends MY_Controller
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
        $this->data->title = $this->data->brandname . ' | Resi';
        $this->data->title_page = 'Resi';
        $this->data->total_orders_resi = $this->order_resi->count_rows();
        $this->data->orders_resis = $this->order_resi->get_all();
        $this->load->view('Resi', $this->data);
    }

    public function save()
    {
        $data_order = array(
            'orders_noid' => $this->input->post('orders_noid'),
            'orders_status' => 6
        );

        $data_resi = array(
            'orders_noid' => $this->input->post('orders_noid'),
            'orders_resi_unik' => $this->input->post('orders_resi_unik'),
            'orders_resi_no' => $this->input->post('resi')
        );

        try {
            $order = $this->order->where('orders_noid', $data_order['orders_noid'])->get();
            $order_resi = $this->order_resi->where('orders_noid', $data_order['orders_noid'])->get();

            if ($order) {
                $order_update = $this->order->update($data_order, 'orders_noid');

                if ($order_update && $order_resi) {
                    $this->order_resi->update($data_resi, 'orders_noid');
                } else {
                    $this->order_resi->insert($data_resi);
                }

                $this->data->berhasil = 'Berhasil membuat resi.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);
            }
        } catch (Exception $e) {
            $this->data->gagal = 'ERROR : ' . $e;
            $this->session->set_flashdata('gagal', $this->data->gagal);
        }

        redirect('Order');
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

    public function tracking_by_resi($airwaybill, $courier)
    {
        $this->load->library('RajaOngkir');
        $result = $this->rajaongkir->waybill($airwaybill, $courier);
        echo $result;
    }


}