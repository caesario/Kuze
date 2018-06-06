<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Order extends MY_Controller
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
        $this->data->title = 'Fashion Grosir | Order';
        $this->data->title_page = 'Order';
        $this->data->total_order = $this->order->count_rows();
        $this->data->orders = $this->order->select_orders();
        $this->load->view('Order', $this->data);
    }

    public function konfirmasi()
    {
        $this->data->title = 'Fashion Grosir | Kofirmasi Order';
        $this->data->title_page = 'Pembayaran';
        $this->data->total_order = $this->order->count_rows();
        $this->data->orders = $this->order->select_orders_bukti(3);
        $this->load->view('Order_k', $this->data);
    }

    public function proses_konfirmasi($id)
    {
        $order = $this->order->where_o_kode($id)->update(
            array(
                'o_status' => 4
            )
        );

        if ($order) {
            $this->data->berhasil = 'Konfirmasi Order berhasil';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('order');
        } else {
            $this->data->gagal = 'Konfirmasi Order gagal';
            $this->session->set_flashdata('gagal', $this->data->gagal);

            redirect('order');
        }
    }

    public function invoice()
    {
        $this->data->title = 'Fashion Grosir | Invoice';
        $this->data->title_page = 'Invoice';
        $this->data->total_order = $this->order->count_rows();
        $this->data->orders = $this->order->select_invoice(6);
        $this->load->view('Order_i', $this->data);
    }

    public function tambah()
    {
        $this->data->title = 'Fashion Grosir | Order > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->order->guid();
        $this->load->view('CRUD_Order', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = 'Fashion Grosir | Order > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->orders = $this->order->where('u_kode', $id)->get();

        $this->load->view('CRUD_Order', $this->data);
    }

    public function simpan()
    {
        // create object
        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $order = $this->order->where_u_kode($id)->get();

        if ($order) {
            $order = $this->order->where_u_kode($id)->update(array(
                'u_nama' => $this->input->post('nama'),
                'updated_by' => $_SESSION['username'],
            ));
            if ($order) {
                $this->data->berhasil = 'Data Order berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('order');
            } else {
                $this->data->gagal = 'Data Order gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('order');
            }
        } else {
            $order = $this->order->insert(array(
                'u_kode' => $this->input->post('id'),
                'u_nama' => $this->input->post('nama'),
//                'created_by'      => $_SESSION['username'],
            ));
            if ($order) {
                $this->data->berhasil = 'Data Order berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('order');
            } else {
                $this->data->gagal = 'Data Order gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('order');
            }
        }
    }

    public function hapus($id)
    {
        $order = $this->order->where('u_kode', $id)->delete();
        if ($order) {
            $this->data->berhasil = 'Data Order berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('order');
        } else {
            $this->data->gagal = 'Data Order gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('order');
        }
    }
}