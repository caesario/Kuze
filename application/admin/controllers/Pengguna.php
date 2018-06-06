<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Pengguna extends MY_Controller
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
        $this->data->title = 'Fashion Grosir | Admin';
        $this->data->total_pengguna = $this->pengguna->count_rows();
        $this->data->users = $this->pengguna->where_p_tipe('0')->get_all();
        $this->load->view('Pengguna', $this->data);
    }

    public function simpan()
    {
        // create object
        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $user = $this->pengguna->where_p_kode($id)->get();

        if ($user) {
            $user = $this->pengguna->where_p_kode($id)->update(array(
                'p_nama' => $this->input->post('nama'),
                'p_username' => $this->input->post('username'),
                'p_password' => $this->input->post('password'),
                'p_email' => $this->input->post('email'),
                'updated_by' => $_SESSION['username'],
            ));
            if ($user) {
                $this->data->berhasil = 'Data Admin berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('pengguna');
            } else {
                $this->data->gagal = 'Data Admin gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('pengguna');
            }
        } else {
            $user = $this->pengguna->insert(array(
                'p_kode' => $this->input->post('id'),
                'p_nama' => $this->input->post('nama'),
                'p_username' => $this->input->post('username'),
                'p_password' => $this->input->post('password'),
                'p_email' => $this->input->post('email'),
//                'created_by'      => $_SESSION['username'],
            ));
            if ($user) {
                $this->data->berhasil = 'Data Admin berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('pengguna');
            } else {
                $this->data->gagal = 'Data Admin gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('pengguna');
            }
        }
    }

    public function tambah()
    {
        $this->data->title = 'Fashion Grosir | Admin > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->pengguna->guid();
        $this->load->view('CRUD_Pengguna', $this->data);
    }

    public function detil($id)
    {
        $this->data->title = 'Fashion Grosir | Admin > Detil';
        $this->data->users = $this->pengguna->where('p_kode', $id)->get();
        $this->load->view('CRUD_Pengguna', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = 'Fashion Grosir | Admin > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->users = $this->pengguna->where('p_kode', $id)->get();

        $this->load->view('CRUD_Pengguna', $this->data);
    }

    public function hapus($id)
    {
        $customer = $this->pengguna->where('p_kode', $id)->delete();
        if ($customer) {
            $this->data->berhasil = 'Data Admin berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('pengguna');
        } else {
            $this->data->gagal = 'Data Admin gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('pengguna');
        }
    }
}