<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Ukuran extends MY_Controller
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
            'field' => 'u_nama',
            'title' => 'title',
            'table' => 'ukuran',
            'id' => 'u_id',
        );
        $this->load->library('slug', $config);
    }

    public function index()
    {
        $this->data->title = 'Fashion Grosir | Ukuran';
        $this->data->title_page = 'Ukuran';
        $this->data->total_ukuran = $this->ukuran->count_rows();
        $this->data->ukurans = $this->ukuran->get_all();
        $this->load->view('Ukuran', $this->data);
    }

    public function tambah()
    {
        $this->data->title = 'Fashion Grosir | Ukuran > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->ukuran->guid();
        $this->load->view('CRUD_Ukuran', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = 'Fashion Grosir | Pelanggan > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->ukurans = $this->ukuran->where('u_kode', $id)->get();

        $this->load->view('CRUD_Ukuran', $this->data);
    }

    public function simpan()
    {
        // create object
        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $ukuran = $this->ukuran->where_u_kode($id)->get();

        if ($ukuran) {
            $ukuran = $this->ukuran->where_u_kode($id)->update(array(
                'u_nama' => $this->input->post('nama'),
                'u_url' => $this->slug->create_uri(array('title' => $this->input->post('nama'))),
            ));
            if ($ukuran) {
                $this->data->berhasil = 'Data Ukuran berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('ukuran');
            } else {
                $this->data->gagal = 'Data Ukuran gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('ukuran');
            }
        } else {
            $ukuran = $this->ukuran->insert(array(
                'u_kode' => $this->input->post('id'),
                'u_nama' => $this->input->post('nama'),
                'u_url' => $this->slug->create_uri(array('title' => $this->input->post('nama'))),
            ));
            if ($ukuran) {
                $this->data->berhasil = 'Data Ukuran berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('ukuran');
            } else {
                $this->data->gagal = 'Data Ukuran gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('ukuran');
            }
        }
    }

    public function hapus($id)
    {
        $ukuran = $this->ukuran->where('u_kode', $id)->delete();
        if ($ukuran) {
            $this->data->berhasil = 'Data Ukuran berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('ukuran');
        } else {
            $this->data->gagal = 'Data Ukuran gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('ukuran');
        }
    }

    public function get($item)
    {
        $this->data->members = $this->ukuran->many_to_many_where($item);
        $this->load->view('Tabel_detil', $this->data);
    }
}