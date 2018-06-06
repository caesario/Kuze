<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Warna extends MY_Controller
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
            'field' => 'w_nama',
            'title' => 'title',
            'table' => 'warna',
            'id' => 'w_id',
        );
        $this->load->library('slug', $config);
    }

    public function index()
    {
        $this->data->title = 'Fashion Grosir | Warna';
        $this->data->title_page = 'Warna';
        $this->data->total_warna = $this->warna->count_rows();
        $this->data->warnas = $this->warna->get_all();
        $this->load->view('Warna', $this->data);
    }

    public function tambah()
    {
        $this->data->title = 'Fashion Grosir | Warna > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->warna->guid();
        $this->load->view('CRUD_Warna', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = 'Fashion Grosir | Warna > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->warnas = $this->warna->where('w_kode', $id)->get();

        $this->load->view('CRUD_Warna', $this->data);
    }

    public function simpan()
    {
        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $warna = $this->warna->where_w_kode($id)->get();

        if ($warna) {
            $warna = $this->warna->where_w_kode($id)->update(array(
                'w_nama' => $this->input->post('nama'),
                'w_url' => $this->slug->create_uri(array('title' => $this->input->post('nama'))),
            ));
            if ($warna) {
                $this->data->berhasil = 'Data Warna berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('warna');
            } else {
                $this->data->gagal = 'Data Warna gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('warna');
            }
        } else {
            $warna = $this->warna->insert(array(
                'w_kode' => $this->input->post('id'),
                'w_nama' => $this->input->post('nama'),
                'w_url' => $this->slug->create_uri(array('title' => $this->input->post('nama'))),
            ));
            if ($warna) {
                $this->data->berhasil = 'Data Warna berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('warna');
            } else {
                $this->data->gagal = 'Data Warna gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('warna');
            }
        }
    }

    public function hapus($id)
    {

        $warna = $this->warna->where('w_kode', $id)->delete();
        if ($warna) {
            $this->data->berhasil = 'Data Warna berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('warna');
        } else {
            $this->data->gagal = 'Data Warna gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('warna');
        }
    }

    public function get($item)
    {
        $this->data->members = $this->warna->many_to_many_where($item);
        $this->load->view('Tabel_detil', $this->data);
    }
}