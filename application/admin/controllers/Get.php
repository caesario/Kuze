<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 11/03/2018
 * Time: 02.03
 */

class Get extends MY_Controller
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

    public function provinsi($where = '')
    {
        // load model
        $this->load->model('Ms_provinsi','provinsi');

        if ($where != ''){
            $json = $this->provinsi->where('provinsi_id', $where)->get();
            echo json_encode($json);
        } else {
            $json = $this->provinsi->get_all();
            echo json_encode($json);
        }

    }

    public function kabupaten($where = '')
    {
        // load model
        $this->load->model('Ms_kabupaten','kabupaten');

        if ($where != ''){
            $json = $this->kabupaten->where('provinsi_id', $where)->get();
            echo json_encode($json);
        } else {
            $json = $this->kabupaten->get_all();
            echo json_encode($json);
        }
    }

    public function kecamatan($where = '')
    {
        // load model
        $this->load->model('Ms_kecamatan', 'KecamatanM');
        if ($where != ''){
            $json = $this->kecamatan->where('kabupaten_id', $where)->get();
            echo json_encode($json);
        } else {
            $json = $this->kecamatan->get_all();
            echo json_encode($json);
        }
    }

    public function desa($where = '')
    {
        // load model
        $this->load->model('Ms_desa','desa');
        if ($where != ''){
            $json = $this->desa->where('kecamatan_id', $where)->get();
            echo json_encode($json);
        } else {
            $json = $this->desa->get_all();
            echo json_encode($json);
        }
    }

    public function kategori()
    {
        //load model
        $this->load->model('Ms_kategori', 'KategoriM');
        $json = $this->kategori->get_all();
        return $json;
    }
}