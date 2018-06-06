<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Seri extends MY_Controller
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
            'field' => 's_nama',
            'title' => 'title',
            'table' => 'seri',
            'id' => 's_id',
        );
        $this->load->library('slug', $config);
    }

    public function index()
    {
        $this->data->title = 'Fashion Grosir | Nomor Seri';
        $this->data->title_page = 'Nomor Seri';
        $this->data->total_seri = $this->seri->count_rows();
        $this->data->seris = $this->seri->get_all();
        $this->load->view('Seri', $this->data);
    }

    public function tambah()
    {
        $this->data->title = 'Fashion Grosir | Nomor Seri > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->seri->guid();
        $this->load->view('CRUD_Seri', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = 'Fashion Grosir | Nomor Seri > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->seris = $this->seri->where('s_kode', $id)->get();

        $this->load->view('CRUD_Seri', $this->data);
    }

    public function simpan()
    {
        // create object

        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $seri = $this->seri->where_s_kode($id)->get();

        if ($seri) {
            $seri = $this->seri->where_s_kode($id)->update(array(
                's_nama' => $this->input->post('nama'),
                's_url' => $this->slug->create_uri(array('title' => $this->input->post('nama'))),
            ));
            if ($seri) {
                $this->data->berhasil = 'Nomor Seri berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('seri');
            } else {
                $this->data->gagal = 'Nomor Seri gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('seri');
            }
        } else {
            $seri = $this->seri->insert(array(
                's_kode' => $this->input->post('id'),
                's_nama' => $this->input->post('nama'),
                's_url' => $this->slug->create_uri(array('title' => $this->input->post('nama'))),

            ));
            if ($seri) {
                $this->data->berhasil = 'Nomor Seri berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('seri');
            } else {
                $this->data->gagal = 'Nomor Seri gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('seri');
            }
        }
    }

    public function hapus($id)
    {

        $seri = $this->seri->where('s_kode', $id)->delete();
        if ($seri) {
            $this->data->berhasil = 'Nomor Seri berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('seri');
        } else {
            $this->data->gagal = 'Nomor Seri gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('seri');
        }
    }

    public function get($item)
    {
        $this->data->members = $this->seri->many_to_many_where($item);
        $this->load->view('Tabel_detil', $this->data);
    }
}