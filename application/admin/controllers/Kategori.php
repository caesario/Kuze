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
        $this->data->title = $this->data->brandname . ' | Kategori';
        $this->data->title_page = 'Kategori';
        $this->data->total_kategori = $this->kategori->count_rows();
        $this->data->kategoris = $this->kategori->get_all();
        $this->load->view('Kategori', $this->data);
    }

    public function tambah()
    {
        $this->data->title = $this->data->brandname . ' | Kategori > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->kategori->guid();
        $this->data->kategoris = $this->kategori->get_all();
        $this->load->view('CRUD_Kategori', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = $this->data->brandname . ' | Kategori > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->kategori = $this->kategori->where('k_kode', $id)->get();
        $this->data->kategoris = $this->kategori->get_all();
        $this->load->view('CRUD_Kategori', $this->data);
    }

    public function simpan()
    {
        $this->form_validation->set_rules('nama','Nama Kategori','is_unique[kategori.k_nama]', array('is_unique' => 'Terdapat nama yang sama. Silahkan coba lagi.'));

        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $kategori = $this->kategori->where('k_kode', $id)->get();
        $kategori_nama = $this->input->post('nama');
        $kategori_array = array(
            'k_kode' => $id,
            'k_nama' => $kategori_nama,
            'k_url' => $this->slug->create_uri(array('title' => $this->input->post('nama')))
        );

        if ($kategori) {
            // validasi
            if ($this->form_validation->run() === FALSE && $kategori->k_nama != $kategori_nama) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('kategori');
            } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $kategori_nama)) {
                $this->data->gagal = 'Karakter untuk kategori tidak diperbolehkan.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('kategori');
            }

            // update
            $kategori_update = $this->kategori->update($kategori_array, 'k_kode');
            if ($kategori_update) {
                $this->data->berhasil = 'Data Kategori berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('kategori');
            } else {
                $this->data->gagal = 'Data Kategori gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('kategori');
            }
        } else {

            // validasi
            if ($this->form_validation->run() === FALSE) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('kategori');
            } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $kategori_nama)) {
                $this->data->gagal = 'Karakter untuk kategori tidak diperbolehkan.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('kategori');
            }

            // insert
            $kategori_insert = $this->kategori->insert($kategori_array);
            if ($kategori_insert) {
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
        $item_kategori = $this->item_kategori->where('k_kode', $id)->get();

        if ($item_kategori)
        {
            $this->data->gagal = 'Kategori ini tidak boleh dihapus karena sedang digunakan';
            $this->session->set_flashdata('gagal', $this->data->gagal);

            redirect('kategori');
        } else {
            $kategori = $this->kategori->where('k_kode', $id)->delete();
            if ($kategori) {
                $this->data->berhasil = 'Data Kategori berhasil dihapus';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('kategori');
            } else {
                $this->data->gagal = 'Data Kategori gagal dihapus';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('kategori');
            }
        }

    }

    public function get($item)
    {
        $this->data->members = $this->kategori->many_to_many_where($item);
        $this->load->view('Tabel_detil', $this->data);
    }


}