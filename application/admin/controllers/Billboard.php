<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Billboard extends MY_Controller
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
    }

    public function index()
    {
        $this->data->title = $this->data->brandname . ' | Billboard';
        $this->data->title_page = 'Billboard';
        $this->data->img1 = $this->billboard->get(1);
        $this->data->img2 = $this->billboard->get(2);
        $this->data->img3 = $this->billboard->get(3);
        $this->data->img4 = $this->billboard->get(4);
        $this->data->img5 = $this->billboard->get(5);
        $this->data->total_billboard = $this->billboard->count_rows();
        $this->data->billboards = $this->billboard->get_all();
        $this->load->view('Billboard', $this->data);
    }

    public function tambah()
    {
        $this->data->title = $this->data->brandname . ' | Gambar Billboard > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->billboard->guid();
        $this->data->billboards = $this->billboard->get_all();
        $this->load->view('CRUD_Billboard', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = $this->data->brandname . ' | Gambar Billboard > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->billboard = $this->billboard->where('blb_kode', $id)->get();
        $this->load->view('CRUD_Billboard', $this->data);
    }

    public function simpan()
    {
        // get user from database where guid
        $billboard_data = file_get_contents($_FILES['foto']['tmp_name']);
        $billboard_type = getimageSize($_FILES['foto']['tmp_name']);

        $billboard_array = array(
            'blb_id' => $this->input->post('id'),
            'blb_judul' => $this->input->post('judul'),
            'blb_url' => $this->input->post('url'),
            'blb_type' => $billboard_type['mime'],
            'blb_data' => $billboard_data,
            'blb_ket' => $this->input->post('ket')
        );


        $billboard_insert = $this->billboard->insert_db($billboard_array);

        if ($billboard_insert) {
            $this->data->berhasil = 'Gambar Billboard berhasil dibuat.';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

        } else {
            $this->data->gagal = 'Gambar Billboard gagal dibuat.';
            $this->session->set_flashdata('gagal', $this->data->gagal);

        }
    }

    public function hapus($id)
    {
        $billboard = $this->billboard->where('blb_kode', $id)->delete();

        if ($billboard) {
            $this->data->berhasil = 'Data Gambar Billboard berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('billboard');
        } else {
            $this->data->gagal = 'Data Gambar Billboard gagal dihapus';
            $this->session->set_flashdata('gagal', $this->data->gagal);

            redirect('billboard');
        }

    }

    protected function upload_img()
    {
        //upload an image options
        $config = array();
        $config['upload_path'] = './upload';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '0';
        $config['overwrite'] = TRUE;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->do_upload('billboard');
        $hasil = $this->upload->data();

        return $hasil;
    }
}