<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Promo extends MY_Controller
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
        $this->data->title = $this->data->brandname . ' | Promo';
        $this->data->title_page = 'Promo';
        $this->data->total_promo = $this->promo->count_rows();
        $this->data->promos = $this->promo->get_all();
        $this->load->view('Promo', $this->data);
    }

    public function tambah()
    {
        $this->data->title = $this->data->brandname . ' | Promo > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->promo->guid();
        $this->load->view('CRUD_Promo', $this->data);
    }

    public function ubah($promo_kode)
    {
        $this->data->title = $this->data->brandname . ' | Promo > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $promo_kode;
        $this->data->promo = $this->promo->where('promo_kode', $promo_kode)->get();
        $this->load->view('CRUD_Promo', $this->data);
    }

    public function simpan()
    {
        $this->form_validation->set_rules('promo_nama', 'Kode Promo', 'is_unique[promo.promo_nama]', array('is_unique' => 'Terdapat kode promo yang sama. Silahkan coba lagi.'));


        // get guid form post
        $id = $this->input->post('promo_kode');

        // get user from database where guid
        $promo = $this->promo->where_promo_kode($id)->get();
        $promo_nama = $this->input->post('promo_nama');

        $promo_array = array(
            'promo_kode' => $id,
            'promo_nama' => $promo_nama,
            'promo_rate' => $this->input->post('promo_rate'),
            'promo_nominal' => $this->input->post('promo_nominal'),
            'promo_ket' => $this->input->post('promo_ket'),
            'promo_aktif' => $this->input->post('promo_aktif')
        );

        if ($promo) {

            // cek validasi
            // validasi
            if ($this->form_validation->run() === FALSE && $promo->promo_nama != $promo_nama) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);
                redirect('promo');
            } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $promo_nama)) {
                $this->data->gagal = 'Karakter untuk item tidak diperbolehkan.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('promo');
            }
            // end validasi

            // update
            $promo_update = $this->promo->update($promo_array, 'promo_kode');

            if ($promo_update) {
                $this->data->berhasil = 'Data Promo berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('promo');
            } else {
                $this->data->gagal = 'Data Promo gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('promo');
            }
            // end update
        } else {

            // cek validasi
            if ($this->form_validation->run() === FALSE) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('promo');
            }
            // end cek validasi

            // insert
            $promo_insert = $this->promo->insert($promo_array);

            if ($promo_insert) {
                $this->data->berhasil = 'Data Promo berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('promo');
            } else {
                $this->data->gagal = 'Data Promo gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('promo');
            }
            // end insert
        }
    }

    public function hapus($promo_kode)
    {

        $promo_hapus = $this->promo->where('promo_kode', $promo_kode)->delete();
        if ($promo_hapus) {
            $this->data->berhasil = 'Data Promo berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('promo');
        } else {
            $this->data->gagal = 'Data Promo gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('promo');
        }
    }
}