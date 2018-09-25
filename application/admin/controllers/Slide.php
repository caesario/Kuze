<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Slide extends MY_Controller
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
        $this->data->title = $this->data->brandname . ' | Slide Promo';
        $this->data->title_page = 'Slide Promo';
        $this->data->total_slide_promo = $this->slide_promo->count_rows();
        $this->data->slide_promos = $this->slide_promo->get_all();
        $this->load->view('Slide', $this->data);
    }

    public function tambah()
    {
        $this->data->title = $this->data->brandname . ' | Slide Promo > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->slide_promo->guid();
        $this->data->slide_promos = $this->slide_promo->get_all();
        $this->load->view('CRUD_Slide', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = $this->data->brandname . ' | Slide Promo > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->slide_promo = $this->slide_promo->where('slide_promo_kode', $id)->get();
        $this->load->view('CRUD_Slide', $this->data);
    }

    public function simpan()
    {
        // get user from database where guid
//        $slide_data = file_get_contents($_FILES['foto']['tmp_name']);
//        $slide_type = getimageSize($_FILES['foto']['tmp_name']);
//
//        $slide_array = array(
//            'slide_promo_caption' => $this->input->post('caption'),
//            'slide_promo_type' => $slide_type['mime'],
//            'slide_promo_data' => $slide_data,
//            'slide_promo_isaktif' => $this->input->post('aktif')
//        );
//
//
//        $slide_insert = $this->slide_promo->insert($slide_array);
//
//        if ($slide_insert) {
//            $this->data->berhasil = 'Foto Slide berhasil dibuat.';
//            $this->session->set_flashdata('berhasil', $this->data->berhasil);
//
//        } else {
//            $this->data->gagal = 'Foto Slide gagal dibuat.';
//            $this->session->set_flashdata('gagal', $this->data->gagal);
//
//        }

        foreach (array_keys($_FILES) as $key) {
            foreach ($_FILES[$key] as $i => $v) {
                echo $_FILES[$key][$i];
                echo '\n';
            }
        }
        foreach (array_keys($_POST) as $key) {
            var_dump($_POST[$key]);
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
        $this->upload->do_upload('slide');
        $hasil = $this->upload->data();

        return $hasil;
    }

    public function hapus($id)
    {
        $slide_promo = $this->slide_promo->where('slide_promo_id', $id)->delete();

        if ($slide_promo) {
            $this->data->berhasil = 'Data Slide Promo berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('slide');
        } else {
            $this->data->gagal = 'Data Slide Promo gagal dihapus';
            $this->session->set_flashdata('gagal', $this->data->gagal);

            redirect('slide');
        }

    }
}