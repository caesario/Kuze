<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil_password extends MY_Controller
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
        $this->load->view('Profil_password', $this->data);
    }

    public function simpan()
    {
        $this->form_validation->set_rules(array(
            array(
                'field' => 'sandi',
                'label' => 'Kata Sandi',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'sandi_konfirm',
                'label' => 'Konfirmasi Kata Sandi',
                'rules' => 'trim|required|matches[sandi]',
                'errors' => array(
                    'matches' => '%s tidak sesuai.'
                )
            )
        ));

        if ($this->form_validation->run() === false) {
            $this->data->gagal = validation_errors();
            $this->session->set_flashdata('gagal', $this->data->gagal);
            redirect('profil_password');
        } else {
            $id = $this->input->post('id');
            $pengguna_array = array(
                'pengguna_kode' => $id,
                'pengguna_password' => $this->input->post('sandi_konfirm')
            );

            $pengguna_update = $this->pengguna->update($pengguna_array, 'pengguna_kode');

            if ($pengguna_update) {
                $this->data->berhasil = 'Password berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);
                redirect('profil_password');
            } else {
                $this->data->gagal = 'Password gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);
                redirect('profil_password');
            }
        }

    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */