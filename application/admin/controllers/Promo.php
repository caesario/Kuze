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

        $config = array(
            'field' => 'promo_nama',
            'title' => 'title',
            'table' => 'promo',
            'id' => 'promo_id',
        );
        $this->load->library('slug', $config);
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
        $this->data->promos = $this->promo->get_all();
        $this->load->view('CRUD_Promo', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = $this->data->brandname . ' | Promo > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->promo = $this->promo->where('promo_kode', $id)->get();
        $this->data->promos = $this->promo->get_all();
        $this->load->view('CRUD_Promo', $this->data);
    }

    public function simpan()
    {
        $this->form_validation->set_rules('rekening', 'Nomor Rek', 'is_unique[promo.promo_rek]', array('is_unique' => 'Terdapat nomor rekening yang sama. Silahkan coba lagi.'));

        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $promo = $this->promo->where_promo_kode($id)->get();
        $promo_rek = $this->input->post('rekening');

        $promo_array = array(
            'promo_kode' => $id,
            'promo_penerbit' => $this->input->post('penerbit'),
            'promo_nama' => $this->input->post('nama'),
            'promo_rek' => $promo_rek,
            'promo_isaktif' => $this->input->post('aktif')
        );

        if ($promo) {

            // cek validasi
            if ($this->form_validation->run() === FALSE && $promo->promo_rek != $promo_rek) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('promo');
            }

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
        } else {

            // cek validasi
            if ($this->form_validation->run() === FALSE) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('promo');
            }

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
        }
    }

    public function hapus($id)
    {

        $promo_hapus = $this->promo->where('promo_kode', $id)->delete();
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