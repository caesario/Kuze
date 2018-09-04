<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trace extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('RajaOngkir', 'rajaongkir');
    }

    public function index()
    {
        redirect('order_status');
    }

    public function find($resi, $kurir)
    {
        $data = json_decode($this->rajaongkir->waybill($resi, $kurir));
        $data = $data->rajaongkir->result;

        $this->data->delivered = $data->delivered;
        $this->data->summary = $data->summary;
        $this->data->details = $data->details;
        $this->data->delivery_status = $data->delivery_status;
        $this->data->manifest = $data->manifest;

        $this->load->view('Trace', $this->data);
    }

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */