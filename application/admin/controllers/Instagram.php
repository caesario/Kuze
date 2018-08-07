<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Instagram extends MY_Controller
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
        $this->data->title = $this->data->brandname . ' | Instagram';
        $this->data->title_page = 'Instagram';
        $this->data->total_slide_insta = $this->slide_insta->count_rows();
        $this->data->slide_instas = $this->slide_insta->get_all();
        $this->load->view('Instagram', $this->data);
    }

    public function tambah()
    {
        $this->data->title = $this->data->brandname . ' | Instagram > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->slide_insta->guid();
        $this->data->slide_instas = $this->slide_insta->get_all();
        $this->load->view('CRUD_Instagram', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = $this->data->brandname . ' | Instagram > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->slide_insta = $this->slide_insta->where('slide_insta_kode', $id)->get();
        $this->load->view('CRUD_Instagram', $this->data);
    }

    public function simpan()
    {
        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $slide_insta = $this->slide_insta->where('slide_insta_kode', $id)->get();

        $slide_insta_array = array(
            'slide_insta_kode' => $this->input->post('id'),
            'slide_insta_img' => $this->input->post('image'),
            'slide_insta_isaktif' => $this->input->post('aktif'),
            'slide_insta_caption' => $this->input->post('caption')
        );

        if ($slide_insta) {
            $slide_insta_update = $this->slide_insta->update($slide_insta_array, 'slide_insta_kode');

            if ($slide_insta_update) {
                $this->data->berhasil = 'Instagram berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('instagram');
            } else {
                $this->data->gagal = 'Instagram gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('instagram');
            }
        } else {

            $slide_insta_insert = $this->slide_insta->insert($slide_insta_array);

            if ($slide_insta_insert) {
                $this->data->berhasil = 'Instagram berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('instagram');
            } else {
                $this->data->gagal = 'Instagram gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('instagram');
            }
        }
    }

    public function hapus($id)
    {
        $slide_insta = $this->slide_insta->where('slide_insta_kode', $id)->delete();

        if ($slide_insta) {
            $this->data->berhasil = 'Data Instagram berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('instagram');
        } else {
            $this->data->gagal = 'Data Instagram gagal dihapus';
            $this->session->set_flashdata('gagal', $this->data->gagal);

            redirect('instagram');
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
}