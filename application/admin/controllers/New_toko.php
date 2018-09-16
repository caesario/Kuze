<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class New_toko extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('RajaOngkir', 'rajaongkir');

        $toko = $this->toko->get();
        $provinsi = $this->provinsi->get(1);
        $kabupaten = $this->kabupaten->get(1);
        $kecamatan = $this->kecamatan->get(1);

        if (!$provinsi) {
            $this->api_provinsi();
        }

        if (!$kabupaten) {
            $this->api_kabupaten();
        }

        if (!$kecamatan) {
            $this->api_kecamatan();
        }

        if ($toko) {
            redirect('new_user');
        }
    }

    public function index()
    {
        // set title
        $this->data->title = $this->data->brandname . ' | Toko';
        $this->data->id = $this->toko->guid();
        $this->load->view('master/New_toko', $this->data);
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
        redirect('new_user');

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

    private function api_provinsi()
    {
        $this->provinsi->delete_all();
        $provinsi = json_decode($this->rajaongkir->province(), true);
        $provinsi = $provinsi['rajaongkir']['results'];
        foreach ($provinsi as $p) {
            $data = array(
                'provinsi_id' => $p['province_id'],
                'provinsi_nama' => $p['province']
            );

            $this->provinsi->insert($data);
        }
        return;
    }

    private function api_kabupaten()
    {
        $this->kabupaten->delete_all();
        $kabupaten = json_decode($this->rajaongkir->city(), true);
        $kabupaten = $kabupaten['rajaongkir']['results'];
        foreach ($kabupaten as $p) {
            $data = array(
                'kabupaten_id' => $p['city_id'],
                'provinsi_id' => $p['province_id'],
                'kabupaten_nama' => $p['city_name'],
                'kodepos' => $p['postal_code']
            );

            $this->kabupaten->insert($data);
        }
        return;
    }

    private function api_kecamatan()
    {
        $this->kecamatan->delete_all();
        $kabupaten = json_decode($this->rajaongkir->city(), true);
        $kabupaten = $kabupaten['rajaongkir']['results'];

        foreach ($kabupaten as $p) {
            $city_id = $p['city_id'];
            $kecamatan = json_decode($this->rajaongkir->subdistrict($city_id));
            $kecamatan = $kecamatan->rajaongkir->results;
            foreach ($kecamatan as $p) {
                $data = array(
                    'kecamatan_id' => $p->subdistrict_id,
                    'kabupaten_id' => $p->city_id,
                    'kecamatan_nama' => $p->subdistrict_name
                );

                $this->kecamatan->insert($data);
            }
        }
        return;
    }

}