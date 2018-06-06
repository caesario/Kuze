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
        $this->data->title = 'Fashion Grosir | Pelanggan';
        $this->data->title_page = 'Pelanggan';
        $this->data->total_customers = $this->pengguna->count_rows();
        $this->data->customers = $this->pengguna->where('p_tipe', array('1', '2'))->get_all();
        $this->load->view('Customers', $this->data);
    }

    public function by_vip()
    {
        $this->data->title = 'Fashion Grosir | Pelanggan VIP';
        $this->data->title_page = 'VIP';
        $this->data->total_customers = $this->pengguna->count_rows();
        $this->data->customers = $this->pengguna->where('p_tipe', '1')->get_all();
        $this->load->view('Customers', $this->data);
    }
    public function by_reseller()
    {
        $this->data->title = 'Fashion Grosir | Pelanggan Reseller';
        $this->data->title_page = 'Reseller';
        $this->data->total_customers = $this->pengguna->count_rows();
        $this->data->customers = $this->pengguna->where('p_tipe', '2')->get_all();
        $this->load->view('Customers', $this->data);
    }

    public function simpan()
    {
        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $customer = $this->pengguna->where_p_kode($id)->get();

        if ($customer)
        {
            $customer = $this->pengguna->where_p_kode($id)->update(array(
                'p_tipe'    => $this->input->post('tipe'),
                'p_nama'    => $this->input->post('nama'),
                'p_username' => $this->input->post('email'),
                'p_password'    => $this->input->post('password'),
                'p_email'       => $this->input->post('email'),
            ));
            if ($customer)
            {
                $this->data->berhasil = 'Data Pelaggan berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('customers');
            }
            else
            {
                $this->data->gagal = 'Data Pelaggan gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('customers');
            }
        }
        else
        {
            $customer = $this->pengguna->insert(array(
                'p_kode'          => $this->input->post('id'),
                'p_tipe' => $this->input->post('tipe'),
                'p_nama' => $this->input->post('nama'),
                'p_username' => $this->input->post('email'),
                'p_password' => $this->input->post('password'),
                'p_email' => $this->input->post('email'),
            ));
            if ($customer)
            {
                $this->data->berhasil = 'Data Pelanggan berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('customers');
            }
            else
            {
                $this->data->gagal = 'Data Pelanggan gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('customers');
            }
        }
    }

    public function tambah()
    {
        $this->data->title = 'Fashion Grosir | Pelanggan > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->pengguna->guid();
        $this->load->view('CRUD_Customers', $this->data);
    }

    public function detil($id)
    {
        $this->data->title = 'Fashion Grosir | Pelanggan > Detil';
        $this->data->customers = $this->pengguna->where('p_kode', $id)->get();
        $this->load->view('CRUD_Customers', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = 'Fashion Grosir | Pelanggan > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->customers = $this->pengguna->where('p_kode', $id)->get();

        $this->load->view('CRUD_Customers', $this->data);
    }

    public  function hapus($id)
    {
        $customer = $this->pengguna->where('p_kode', $id)->delete();
        if ($customer)
        {
            $this->data->berhasil = 'Data Pelanggan berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('customers');
        }
        else
        {
            $this->data->gagal = 'Data Pelanggan gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('customers');
        }
    }
}