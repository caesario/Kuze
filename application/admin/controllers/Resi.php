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


}