<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 22.54
 */

class Dashboard extends MY_Controller
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
        // set title
        $this->data->title = 'Fashion Grosir | Dashboard';

        // set total
        $this->data->totalitem = $this->set_totalitem();
        $this->data->totalcustomer = $this->set_totalcustomer();
        $this->data->totalorder = $this->set_totalorder();
        $this->data->totalinv = $this->set_totalinv();

        $this->load->view('Dashboard', $this->data);
    }

    private function set_totalitem()
    {
        // load model
        $this->load->model('Item_m','item');
        $total = $this->item->count_rows();
        return $total;
    }

    private function set_totalcustomer()
    {
        // load model
        $this->load->model('Pengguna_m','customer');
        $total = $this->customer->where('p_tipe',array('1','2'))->count_rows();
        return $total;
    }

    private function set_totalorder()
    {
        // load model
        $this->load->model('Order_m','order');
        $total = $this->order->count_rows();
        return $total;
    }

    private function set_totalinv()
    {
        // load model
        $this->load->model('Order_m','order');
        $total = $this->order->where_o_status(4)->count_rows();
        return $total;
    }

    private function set_totalpernjualan()
    {
        $total = 0;
        return total;
    }
}