<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alamat_profil extends MY_Controller
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
        $this->load->view('Alamat_profil', $this->data);
    }

    public function simpan()
    {
        $a_kode = $this->input->post('alamat_kode');

        $alamat = $this->alamat->where('alamat_kode', $a_kode)->get();

        if ($alamat) {
            $alamat = $this->alamat->where('alamat_kode', $a_kode)->update(array(
                'alamat_provinsi' => $this->input->post('provinsi'),
                'alamat_kabupaten' => $this->input->post('kabupaten'),
                'alamat_kecamatan' => $this->input->post('kecamatan'),
                'alamat_desa' => $this->input->post('kelurahan'),
                'alamat_kodepos' => $this->input->post('kodepos'),
                'alamat_deskripsi' => $this->input->post('alamat')
            ));

            $alamat_pengguna = $this->pengguna_alamat->where('alamat_kode', $a_kode)->update(array(
                'pengguna_kode' => $_SESSION['id'],
                'pengguna_alamat_r_nama' => $this->input->post('nama_penerima'),
                'pengguna_alamat_r_kontak' => $this->input->post('kontak_penerima'),
                'pengguna_alamat_s_nama' => $this->input->post('nama_pengirim'),
                'pengguna_alamat_s_kontak' => $this->input->post('kontak_pengirim'),
            ));

            if ($alamat && $alamat_pengguna) {
                $this->data->berhasil = 'Alamat berhasil diupdate.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('Alamat_profil');
            } else {
                $this->data->gagal = 'Alamat gagal diupdate.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('Alamat_profil');
            }
        }
    }

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */