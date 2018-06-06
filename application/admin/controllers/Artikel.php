<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Artikel extends MY_Controller
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
            'field' => 'ar_judul',
            'title' => 'title',
            'table' => 'artikel',
            'id' => 'ar_id',
        );
        $this->load->library('slug', $config);
    }

    public function index()
    {
        $this->data->title = 'Fashion Grosir | Artikel';
        $this->data->title_page = 'Artikel';
        $this->data->total_artikel = $this->artikel->count_rows();
        $this->data->artikels = $this->artikel->get_all();
        $this->load->view('Artikel', $this->data);
    }

    public function tambah()
    {
        $this->data->title = 'Fashion Grosir | Artikel > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->artikel->guid();
        $this->data->artikels = $this->artikel->get_all();
        $this->load->view('CRUD_Artikel', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = 'Fashion Grosir | Artikel > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->artikel = $this->artikel->where('ar_kode', $id)->get();
        $this->data->artikels = $this->artikel->get_all();
        $this->load->view('CRUD_Artikel', $this->data);
    }

    public function simpan()
    {
        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $artikel = $this->artikel->where_ar_kode($id)->get();

        if ($artikel) {
            $artikel = $this->artikel->where_ar_kode($id)->update(array(
                'ar_judul' => $this->input->post('judul'),
                'ar_content' => $this->input->post('content'),
                'ar_url' => $this->slug->create_uri(array('title' => $this->input->post('judul'))),
                'ar_ispromo' => $this->input->post('promo'),
                'ar_isblog' => $this->input->post('blog'),
                'ar_isresi' => $this->input->post('resi'),
                'ar_isnotifikasi' => $this->input->post('pengumuman'),
                'ar_isaktif' => $this->input->post('aktif')
            ));
            if ($artikel) {
                $this->data->berhasil = 'Artikel berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('artikel');
            } else {
                $this->data->gagal = 'Artikel gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('artikel');
            }
        } else {
            $artikel = $this->artikel->insert(array(
                'ar_kode' => $this->input->post('id'),
                'ar_judul' => $this->input->post('judul'),
                'ar_content' => $this->input->post('content'),
                'ar_url' => $this->slug->create_uri(array('title' => $this->input->post('judul'))),
                'ar_ispromo' => $this->input->post('promo'),
                'ar_isblog' => $this->input->post('blog'),
                'ar_isresi' => $this->input->post('resi'),
                'ar_isnotifikasi' => $this->input->post('pengumuman'),
                'ar_isaktif' => $this->input->post('aktif')
            ));
            if ($artikel) {
                $this->data->berhasil = 'Artikel berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('artikel');
            } else {
                $this->data->gagal = 'Artikel gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('artikel');
            }
        }
    }

    public function hapus($id)
    {

        $artikel = $this->artikel->where('ar_kode', $id)->delete();
        if ($artikel) {
            $this->data->berhasil = 'Artikel berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('artikel');
        } else {
            $this->data->gagal = 'Artikel gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('artikel');
        }
    }
}