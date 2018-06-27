<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Toko extends MY_Controller
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

    public function index() {
        // set title
        $this->data->title = $this->data->brandname . ' | Toko';
        $this->data->id = $this->toko->guid();
        $this->data->toko = $this->toko->get();
        $this->load->view('Toko', $this->data);
    }

    public function simpan()
    {
        $logo = $this->upload_logo();
        $icon = $this->upload_icon();

        $id = $this->input->post('t_kode');
        $toko = $this->toko->where('t_kode', $id)->get();

        $toko_nama = $this->input->post('nama');
        $toko_nama = preg_replace('/[^\p{L}\p{N}\s]/u', '', $toko_nama);
        $toko_singkatan = $this->input->post('singkatan');
        $toko_singkatan = preg_replace('/[^\p{L}\p{N}\s]/u', '', $toko_singkatan);

        $toko_array = array(
            't_kode' => $id,
            't_nama' => $toko_nama,
            't_singkatan' => $toko_singkatan,
            't_url' => $this->input->post('url'),
            't_provinsi' => $this->input->post('provinsi'),
            't_kabupaten' => $this->input->post('kabupaten'),
            't_kecamatan' => $this->input->post('kecamatan'),
            't_desa' => $this->input->post('kelurahan'),
            't_kodepos' => $this->input->post('kodepos'),
            't_alamat' => $this->input->post('alamat'),
            't_email' => $this->input->post('email'),
            't_line' => $this->input->post('facebook'),
            't_insta' => $this->input->post('instagram'),
            't_wa' => $this->input->post('whatsapp'),
            't_logo' => $logo['file_name'],
            't_icon' => $icon['file_name'],
        );

        if ($toko) {
            $toko_update = $this->toko->update($toko_array, 't_kode');

            if ($toko_update) {
                $this->data->berhasil = 'Informasi Toko berhasil diupdate.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

            } else {
                $this->data->berhasil = 'Informasi Toko gagal diupdate.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

            }
        } else {
            $toko_insert = $this->toko->insert($toko_array);

            if ($toko_insert) {
                $this->data->berhasil = 'Informasi Toko berhasil diupdate.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);
            } else {
                $this->data->berhasil = 'Informasi Toko gagal diupdate.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);
            }
        }
        redirect('toko');

    }

    protected function upload_logo()
    {
        //upload an image options
        $config = array();
        $config['upload_path'] = './upload';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '0';
        $config['overwrite'] = TRUE;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->do_upload('logo');
        $hasil = $this->upload->data();

        return $hasil;
    }

    protected function upload_icon()
    {
        //upload an image options
        $config = array();
        $config['upload_path'] = './upload';
        $config['allowed_types'] = 'ico';
        $config['max_size'] = '0';
        $config['overwrite'] = TRUE;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->do_upload('icon');
        $hasil = $this->upload->data();

        return $hasil;
    }

}