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
            'field' => 'bank_nama',
            'title' => 'title',
            'table' => 'bank',
            'id' => 'bank_id',
        );
        $this->load->library('slug', $config);
    }

    public function index()
    {
        $this->data->title = $this->data->brandname . ' | Bank';
        $this->data->title_page = 'Bank';
        $this->data->total_bank = $this->bank->count_rows();
        $this->data->banks = $this->bank->get_all();
        $this->load->view('Bank', $this->data);
    }

    public function tambah()
    {
        $this->data->title = $this->data->brandname . ' | Bank > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->bank->guid();
        $this->data->banks = $this->bank->get_all();
        $this->load->view('CRUD_Bank', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = $this->data->brandname . ' | Bank > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->bank = $this->bank->where('bank_kode', $id)->get();
        $this->data->banks = $this->bank->get_all();
        $this->load->view('CRUD_Bank', $this->data);
    }

    public function simpan()
    {
        $this->form_validation->set_rules('rekening', 'Nomor Rek', 'is_unique[bank.bank_rek]', array('is_unique' => 'Terdapat nomor rekening yang sama. Silahkan coba lagi.'));

        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $bank = $this->bank->where_bank_kode($id)->get();
        $bank_rek = $this->input->post('rekening');

        $bank_array = array(
            'bank_kode' => $id,
            'bank_penerbit' => $this->input->post('penerbit'),
            'bank_nama' => $this->input->post('nama'),
            'bank_rek' => $bank_rek,
            'bank_isaktif' => $this->input->post('aktif')
        );

        if ($bank) {

            // cek validasi
            if ($this->form_validation->run() === FALSE && $bank->bank_rek != $bank_rek) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('bank');
            }

            // update
            $bank_update = $this->bank->update($bank_array, 'bank_kode');

            if ($bank_update) {
                $this->data->berhasil = 'Data Bank berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('bank');
            } else {
                $this->data->gagal = 'Data Bank gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('bank');
            }
        } else {

            // cek validasi
            if ($this->form_validation->run() === FALSE) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('bank');
            }

            // insert
            $bank_insert = $this->bank->insert($bank_array);

            if ($bank_insert) {
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

        $order_payment = $this->order_payment->where('bank_kode', $id)->get();
        if (!$order_payment) {
            $this->bank->where('bank_kode', $id)->delete();
            $this->data->berhasil = 'Data Bank berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('bank');
        } else {
            $this->data->gagal = 'Data Bank gagal dihapus';
            $this->session->set_flashdata('gagal', $this->data->gagal);

            redirect('bank');
        }
    }


}