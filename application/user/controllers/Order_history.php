<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_history extends MY_Controller
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
        $this->data->total_order = $this->order->count_rows();
        $this->data->orders = $this->order->select_orders_users($_SESSION['id']);
        $this->load->view('Order_history', $this->data);
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */