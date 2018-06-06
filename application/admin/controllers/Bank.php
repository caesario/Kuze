<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Bank extends MY_Controller
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
            'field' => 'k_nama',
            'title' => 'title',
            'table' => 'bank',
            'id' => 'k_id',
        );
        $this->load->library('slug', $config);
    }

    public function index()
    {
        $this->data->title = 'Fashion Grosir | Bank';
        $this->data->title_page = 'Bank';
        $this->data->total_bank = $this->bank->count_rows();
        $this->data->banks = $this->bank->get_all();
        $this->load->view('Bank', $this->data);
    }

    public function tambah()
    {
        $this->data->title = 'Fashion Grosir | Bank > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->bank->guid();
        $this->data->banks = $this->bank->get_all();
        $this->load->view('CRUD_Bank', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = 'Fashion Grosir | Bank > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->bank = $this->bank->where('b_kode', $id)->get();
        $this->data->banks = $this->bank->get_all();
        $this->load->view('CRUD_Bank', $this->data);
    }

    public function simpan()
    {
        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $bank = $this->bank->where_b_kode($id)->get();

        if ($bank) {
            $bank = $this->bank->where_b_kode($id)->update(array(
                'b_penerbit' => $this->input->post('penerbit'),
                'b_nama' => $this->input->post('nama'),
                'b_rek' => $this->input->post('rekening'),
                'b_isaktif' => $this->input->post('aktif')
            ));
            if ($bank) {
                $this->data->berhasil = 'Data Bank berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('bank');
            } else {
                $this->data->gagal = 'Data Bank gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('bank');
            }
        } else {
            $bank = $this->bank->insert(array(
                'b_kode' => $id,
                'b_penerbit' => $this->input->post('penerbit'),
                'b_nama' => $this->input->post('nama'),
                'b_rek' => $this->input->post('rekening'),
                'b_isaktif' => $this->input->post('aktif')
            ));
            if ($bank) {
                $this->data->berhasil = 'Data Bank berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('bank');
            } else {
                $this->data->gagal = 'Data Bank gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('bank');
            }
        }
    }

    public function hapus($id)
    {

        $bank = $this->bank->where('b_kode', $id)->delete();
        if ($bank) {
            $this->data->berhasil = 'Data Bank berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('bank');
        } else {
            $this->data->gagal = 'Data Bank gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('bank');
        }
    }
}