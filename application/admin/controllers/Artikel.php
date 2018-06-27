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
            'field' => 'artikel_judul',
            'title' => 'title',
            'table' => 'artikel',
            'id' => 'artikel_id',
        );
        $this->load->library('slug', $config);
    }

    public function index()
    {
        $this->data->title = $this->data->brandname . ' | Artikel';
        $this->data->title_page = 'Artikel';
        $this->data->total_artikel = $this->artikel->count_rows();
        $this->data->artikels = $this->artikel->get_all();
        $this->load->view('Artikel', $this->data);
    }

    public function tambah()
    {
        $this->data->title = $this->data->brandname . ' | Artikel > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->artikel->guid();
        $this->data->artikels = $this->artikel->get_all();
        $this->load->view('CRUD_Artikel', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = $this->data->brandname . ' | Artikel > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->artikel = $this->artikel->where('artikel_kode', $id)->get();
        $this->data->artikels = $this->artikel->get_all();
        $this->load->view('CRUD_Artikel', $this->data);
    }

    public function simpan()
    {
        $this->form_validation->set_rules('judul', 'Judul', 'is_unique[artikel.artikel_judul]', array('is_unique' => 'Terdapat nama yang sama. Silahkan coba lagi.'));

        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $artikel = $this->artikel->where_artikel_kode($id)->get();
        $artikel_judul = $this->input->post('judul');

        $artikel_array = array(
            'artikel_kode' => $id,
            'artikel_judul' => $artikel_judul,
            'artikel_content' => $this->input->post('content'),
            'artikel_url' => $this->slug->create_uri(array('title' => $this->input->post('judul'))),
            'artikel_ispromo' => $this->input->post('promo'),
            'artikel_isblog' => $this->input->post('blog'),
            'artikel_isresi' => 0,
            'artikel_isnotifikasi' => $this->input->post('notikasi'),
            'artikel_isaktif' => $this->input->post('aktif')
        );

        if ($artikel) {
            // cek validasi
            if ($this->form_validation->run() === FALSE && $artikel->artikel_judul != $artikel_judul) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('artikel');
            } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $artikel_judul)) {
                $this->data->gagal = 'Karakter untuk judul tidak diperbolehkan.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('artikel');
            }

            // update
            $artikel_update = $this->artikel->update($artikel_array, 'artikel_kode');

            if ($artikel_update) {
                $this->data->berhasil = 'Artikel berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('artikel');
            } else {
                $this->data->gagal = 'Artikel gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('artikel');
            }
        } else {
            // cek validasi
            if ($this->form_validation->run() === FALSE) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('artikel');
            } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $artikel_judul)) {
                $this->data->gagal = 'Karakter untuk judul tidak diperbolehkan.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('artikel');
            }

            // insert
            $artikel_insert = $this->artikel->insert($artikel_array);

            if ($artikel_insert) {
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

        $artikel = $this->artikel->where('artikel_kode', $id)->delete();
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