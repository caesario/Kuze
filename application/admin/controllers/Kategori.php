<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Kategori extends MY_Controller
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
            'table' => 'kategori',
            'id' => 'k_id',
        );
        $this->load->library('slug', $config);
    }

    public function index()
    {
        $this->data->title = 'Fashion Grosir | Kategori';
        $this->data->title_page = 'Kategori';
        $this->data->total_kategori = $this->kategori->count_rows();
        $this->data->kategoris = $this->kategori->get_all();
        $this->load->view('Kategori', $this->data);
    }

    public function tambah()
    {
        $this->data->title = 'Fashion Grosir | Kategori > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->kategori->guid();
        $this->data->kategoris = $this->kategori->where_k_parent_kode(0)->get_all();
        $this->load->view('CRUD_Kategori', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = 'Fashion Grosir | Pelanggan > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->kategori = $this->kategori->where('k_kode', $id)->get();
        $this->data->kategoris = $this->kategori->where_k_parent_kode(0)->get_all();
        $this->load->view('CRUD_Kategori', $this->data);
    }

    public function simpan()
    {
        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $kategori = $this->kategori->where_k_kode($id)->get();

        if ($kategori) {
            $kategori = $this->kategori->where_k_kode($id)->update(array(
                'k_parent_kode' => $this->input->post('parent'),
                'k_nama' => $this->input->post('nama'),
                'k_url'  => $this->slug->create_uri(array('title' => $this->input->post('nama')))
            ));
            if ($kategori) {
                $this->data->berhasil = 'Data Kategori berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('kategori');
            } else {
                $this->data->gagal = 'Data Kategori gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('kategori');
            }
        } else {
            $kategori = $this->kategori->insert(array(
                'k_kode' => $this->input->post('id'),
                'k_parent_kode' => $this->input->post('parent'),
                'k_nama' => $this->input->post('nama'),
                'k_url'  => $this->slug->create_uri(array('title' => $this->input->post('nama')))
            ));
            if ($kategori) {
                $this->data->berhasil = 'Data Kategori berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('kategori');
            } else {
                $this->data->gagal = 'Data Kategori gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('kategori');
            }
        }
    }

    public function hapus($id)
    {

        $kategori = $this->kategori->where('k_kode', $id)->delete();
        if ($kategori) {
            $this->data->berhasil = 'Data Kategori berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('kategori');
        } else {
            $this->data->gagal = 'Data Kategori gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('kategori');
        }
    }

    public function get($item)
    {
        $this->data->members = $this->kategori->many_to_many_where($item);
        $this->load->view('Tabel_detil', $this->data);
    }
}