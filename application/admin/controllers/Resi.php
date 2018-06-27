<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Resi extends MY_Controller
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
        $this->data->title = $this->data->brandname . ' | Resi';
        $this->data->title_page = 'Resi';
        $this->data->total_artikel = $this->artikel->count_rows();
        $this->data->artikels = $this->artikel->where('artikel_isresi', 1)->get_all();
        $this->load->view('Resi', $this->data);
    }

    public function tambah()
    {
        $this->data->title = $this->data->brandname . ' | Resi > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->artikel->guid();
        $this->load->view('CRUD_Resi', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = $this->data->brandname . ' | Resi > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->artikel = $this->artikel->where('artikel_kode', $id)->get();
        $this->load->view('CRUD_Resi', $this->data);
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
            'artikel_judul' => $this->input->post('judul'),
            'artikel_content' => $this->input->post('content'),
            'artikel_url' => $this->slug->create_uri(array('title' => $this->input->post('judul'))),
            'artikel_isresi' => 1,
            'artikel_isaktif' => 1
        );
        if ($artikel) {
            // cek validasi
            if ($this->form_validation->run() === FALSE && $artikel->artikel_judul != $artikel_judul) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('resi');
            }

            $artikel_update = $this->artikel->update($artikel_array, 'artikel_kode');
            if ($artikel_update) {
                $this->data->berhasil = 'Resi berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('resi');
            } else {
                $this->data->gagal = 'Resi gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('resi');
            }
        } else {
            // cek validasi
            if ($this->form_validation->run() === FALSE) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('resi');
            }

            $artikel_insert = $this->artikel->insert(array(
                'artikel_kode' => $id,
                'artikel_judul' => $this->input->post('judul'),
                'artikel_content' => $this->input->post('content'),
                'artikel_url' => $this->slug->create_uri(array('title' => $this->input->post('judul'))),
                'artikel_isresi' => 1,
                'artikel_isaktif' => 1
            ));
            if ($artikel_insert) {
                $this->data->berhasil = 'Resi berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('resi');
            } else {
                $this->data->gagal = 'Resi gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('resi');
            }
        }
    }

    public function hapus($id)
    {

        $artikel = $this->artikel->where('artikel_kode', $id)->delete();
        if ($artikel) {
            $this->data->berhasil = 'Resi berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('resi');
        } else {
            $this->data->gagal = 'Resi gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('resi');
        }
    }
}