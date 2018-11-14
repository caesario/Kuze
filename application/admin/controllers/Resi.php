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
            'orders_resi_no' => $this->input->post('resi')
        );

        try {
            $order = $this->order->where('orders_noid', $data_order['orders_noid']);
            $order_resi = $this->order_resi->where('orders_noid', $data_order['orders_noid']);

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


}