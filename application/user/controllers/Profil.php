Profil_password.php<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends MY_Controller
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
        $this->data->profil = $this->pengguna->where('pengguna_kode', $_SESSION['id'])->get();
        $this->load->view('Profil', $this->data);
    }

    public function simpan()
    {
        $id = $this->input->post('id');

        $profil = $this->pengguna->where('pengguna_kode', $id)->update(array(
            'pengguna_nama' => $this->input->post('nama'),
            'pengguna_email' => $this->input->post('email'),
            'pengguna_telp' => $this->input->post('notelp'),
        ));

        if ($profil) {
            $this->data->berhasil = 'Profil berhasil diupdate.';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('profil');
        } else {
            $this->data->gagal = 'Profil gagal diupdate.';
            $this->session->set_flashdata('gagal', $this->data->gagal);

            redirect('profil');
        }
    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */