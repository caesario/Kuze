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
        $this->data->title = $this->data->brandname . ' | Admin';
        $this->data->total_pengguna = $this->pengguna->count_rows();
        $this->data->users = $this->pengguna->where_pengguna_tipe('0')->get_all();
        $this->load->view('Pengguna', $this->data);
    }


    public function simpan()
    {
        $this->form_validation->set_rules('username', 'Username', 'is_unique[pengguna.pengguna_username]', array('is_unique' => 'Terdapat username yang sama. Silahkan coba lagi.'));
        $this->form_validation->set_rules('email', 'E-mail', 'is_unique[pengguna.pengguna_email]', array('is_unique' => 'Terdapat email yang sama. Silahkan coba lagi.'));

        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $user = $this->pengguna->where_pengguna_kode($id)->get();
        $user_username = $this->input->post('username');
        $user_email = $this->input->post('email');
        $user_array = array(
            'pengguna_kode' => $id,
            'pengguna_nama' => $this->input->post('nama'),
            'pengguna_username' => $this->input->post('username'),
            'pengguna_password' => $this->input->post('password'),
            'pengguna_email' => $this->input->post('email'),
            'pengguna_isaktif' => 1
        );

        if ($user) {
            // cek validasi
            if ($this->form_validation->run() === FALSE && $user->pengguna_username != $user_username && $user->pengguna_email != $user_email) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('customers');
            }

            // update
            $user_update = $this->pengguna->update($user_array, 'pengguna_kode');
            if ($user_update) {
                $this->data->berhasil = 'Data Admin berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('pengguna');
            } else {
                $this->data->gagal = 'Data Admin gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('pengguna');
            }
        } else {
            // cek validasi
            if ($this->form_validation->run() === FALSE) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('customers');
            }

            $user_insert = $this->pengguna->insert($user_array);
            if ($user_insert) {
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
        $this->data->title = $this->data->brandname . ' | Admin > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->pengguna->guid();
        $this->load->view('CRUD_Pengguna', $this->data);
    }

    public function detil($id)
    {
        $this->data->title = $this->data->brandname . ' | Admin > Detail';
        $this->data->users = $this->pengguna->where('pengguna_kode', $id)->get();
        $this->load->view('CRUD_Pengguna', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = $this->data->brandname . ' | Admin > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->users = $this->pengguna->where('pengguna_kode', $id)->get();

        $this->load->view('CRUD_Pengguna', $this->data);
    }

    public function hapus($id)
    {
        $customer = $this->pengguna->where('pengguna_kode', $id)->delete();
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