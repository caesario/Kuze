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
        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $slide_promo = $this->slide_promo->where('slide_promo_kode', $id)->get();

        $slide_promo_array = array(
            'slide_promo_kode' => $this->input->post('id'),
            'slide_promo_img' => $this->input->post('image'),
            'slide_promo_isaktif' => $this->input->post('aktif'),
            'slide_promo_caption' => $this->input->post('caption')
        );

        if ($slide_promo) {
            $slide_promo_update = $this->slide_promo->update($slide_promo_array, 'slide_promo_kode');

            if ($slide_promo_update) {
                $this->data->berhasil = 'Slide Promo berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('slide');
            } else {
                $this->data->gagal = 'Slide Promo gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('slide');
            }
        } else {

            $slide_promo_insert = $this->slide_promo->insert($slide_promo_array);

            if ($slide_promo_insert) {
                $this->data->berhasil = 'Slide Promo berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('slide');
            } else {
                $this->data->gagal = 'Slide Promo gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('slide');
            }
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
        $slide_promo = $this->slide_promo->where('slide_promo_kode', $id)->delete();

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