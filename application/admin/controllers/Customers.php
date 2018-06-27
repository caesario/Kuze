<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Customers extends MY_Controller
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
        $this->data->title = $this->data->brandname . ' | Pelanggan';
        $this->data->title_page = 'Pelanggan';
        $this->data->total_customers = $this->pengguna->count_rows();
        $this->data->customers = $this->pengguna->where('pengguna_tipe', array('1', '2'))->get_all();
        $this->load->view('Customers', $this->data);
    }

    public function by_vip()
    {
        $this->data->title = $this->data->brandname . ' | Pelanggan VIP';
        $this->data->title_page = 'VIP';
        $this->data->total_customers = $this->pengguna->count_rows();
        $this->data->customers = $this->pengguna->where('pengguna_tipe', '1')->get_all();
        $this->load->view('Customers', $this->data);
    }

    public function by_reseller()
    {
        $this->data->title = $this->data->brandname . ' | Pelanggan Reseller';
        $this->data->title_page = 'Reseller';
        $this->data->total_customers = $this->pengguna->count_rows();
        $this->data->customers = $this->pengguna->where('pengguna_tipe', '2')->get_all();
        $this->load->view('Customers', $this->data);
    }

    public function simpan()
    {
        $this->form_validation->set_rules('email', 'E-mail', 'is_unique[pengguna.pengguna_username]', array('is_unique' => 'Terdapat email yang sama. Silahkan coba lagi.'));

        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $customer = $this->pengguna->where_pengguna_kode($id)->get();
        $customer_email = $this->input->post('email');
        $customer_array = array(
            'pengguna_kode' => $id,
            'pengguna_tipe' => $this->input->post('tipe'),
            'pengguna_nama' => $this->input->post('nama'),
            'pengguna_username' => $customer_email,
            'pengguna_password' => $this->input->post('password'),
            'pengguna_email' => $customer_email
        );

        if ($customer) {
            // cek validasi
            if ($this->form_validation->run() === FALSE && $customer->pengguna_username != $customer_email) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('customers');
            }

            // update
            $customer_update = $this->pengguna->update($customer_array, 'pengguna_kode');
            if ($customer_update) {
                $this->data->berhasil = 'Data Pelaggan berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('customers');
            } else {
                $this->data->gagal = 'Data Pelaggan gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('customers');
            }
        } else {

            // cek validasi
            if ($this->form_validation->run() === FALSE) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('customers');
            }

            $customer_insert = $this->pengguna->insert($customer_array);
            if ($customer_insert) {
                $this->data->berhasil = 'Data Pelanggan berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('customers');
            } else {
                $this->data->gagal = 'Data Pelanggan gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('customers');
            }
        }
    }

    public function tambah()
    {
        $this->data->title = $this->data->brandname . ' | Pelanggan > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->pengguna->guid();
        $this->load->view('CRUD_Customers', $this->data);
    }

    public function detil($id)
    {
        $this->data->title = $this->data->brandname . ' | Pelanggan > Detail';
        $this->data->customers = $this->pengguna->where('pengguna_kode', $id)->get();
        $this->load->view('CRUD_Customers', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = $this->data->brandname . ' | Pelanggan > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->customers = $this->pengguna->where('pengguna_kode', $id)->get();

        $this->load->view('CRUD_Customers', $this->data);
    }

    public function hapus($id)
    {
        $customer = $this->pengguna->where('pengguna_kode', $id)->delete();
        if ($customer) {
            $this->data->berhasil = 'Data Pelanggan berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('customers');
        } else {
            $this->data->gagal = 'Data Pelanggan gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('customers');
        }
    }
}