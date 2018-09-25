<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_provinsi($id = '')
    {
        $data['results'] = [];
        $q = $this->input->get('q');
        if ($id == '') {
            if (isset($q)) {
                $hasil = $this->provinsi->where('provinsi_nama LIKE', '%' . $q . '%')->get_all();
                foreach ($hasil as $g) {
                    array_push($data['results'], array('id' => $g->provinsi_id, 'text' => $g->provinsi_nama));

                }
            } else {
                foreach ($this->provinsi->get_all() as $g) {
                    array_push($data['results'], array('id' => $g->provinsi_id, 'text' => $g->provinsi_nama));
                }
            }

        } else {
            $g = $this->provinsi->where('provinsi_id', $id)->get();
            array_push($data['results'], array('id' => $g->provinsi_id, 'text' => $g->provinsi_nama));
        }


        echo json_encode($data);
    }

    public function get_kabupaten($id = '')
    {
        $data['results'] = [];
        $provinsi = $this->input->get('provinsi');
        $q = $this->input->get('q');

        if ($id == '') {
            if (isset($q)) {
                $hasil = $this->kabupaten->where('provinsi_id', $provinsi)->where('kabupaten_nama LIKE', '%' . $q . '%')->get_all();
                foreach ($hasil as $g) {
                    array_push($data['results'], array('id' => $g->kabupaten_id, 'text' => $g->kabupaten_nama));

                }
            } else {
                $hasil = $this->kabupaten->where('provinsi_id', $provinsi)->get_all();
                foreach ($hasil as $g) {
                    array_push($data['results'], array('id' => $g->kabupaten_id, 'text' => $g->kabupaten_nama));
                }
            }
        } else {
            $g = $this->kabupaten->where('kabupaten_id', $id)->get();
            array_push($data['results'], array('id' => $g->kabupaten_id, 'text' => $g->kabupaten_nama));
        }
        echo json_encode($data);
    }

    public function get_kecamatan($id = '')
    {
        $data['results'] = [];
        $kabupaten = $this->input->get('kabupaten');
        $q = $this->input->get('q');
        if ($id == '') {
            if (isset($q)) {
                $hasil = $this->kecamatan->where('kabupaten_id', $kabupaten)->where('kecamatan_nama LIKE', '%' . $q . '%')->get_all();
                foreach ($hasil as $g) {
                    array_push($data['results'], array('id' => $g->kecamatan_id, 'text' => $g->kecamatan_nama));

                }
            } else {
                $hasil = $this->kecamatan->where('kabupaten_id', $kabupaten)->get_all();
                foreach ($hasil as $g) {
                    array_push($data['results'], array('id' => $g->kecamatan_id, 'text' => $g->kecamatan_nama));
                }
            }
        } else {
            $g = $this->kecamatan->where('kecamatan_id', $id)->get();
            array_push($data['results'], array('id' => $g->kecamatan_id, 'text' => $g->kecamatan_nama));
        }

        echo json_encode($data);
    }

    public function get_kelurahan($id = '')
    {
        $data['results'] = [];
        $kecamatan = $this->input->get('kecamatan');
        $q = $this->input->get('q');
        if ($id == '') {
            if (isset($q)) {
                $hasil = $this->desa->where('kecamatan_id', $kecamatan)->where('desa_nama LIKE', '%' . $q . '%')->get_all();
                foreach ($hasil as $g) {
                    array_push($data['results'], array(
                        'id' => (int)$g->desa_id,
                        'text' => (string)$g->desa_nama,
                        'kodepos' => (int)$g->kodepos
                    ));

                }
            } else {
                $hasil = $this->desa->where('kecamatan_id', $kecamatan)->get_all();
                foreach ($hasil as $g) {
                    array_push($data['results'], array(
                        'id' => (int)$g->desa_id,
                        'text' => (string)$g->desa_nama,
                        'kodepos' => (int)$g->kodepos
                    ));

                }
            }
        } else {
            $g = $this->desa->where('desa_id', $id)->get();
            array_push($data['results'], array(
                'id' => (int)$g->desa_id,
                'text' => (string)$g->desa_nama,
                'kodepos' => (int)$g->kodepos
            ));

        }


        echo json_encode($data);
    }

    public function get_kodepos($kabupaten_id)
    {
        $hasil = $this->kabupaten->get($kabupaten_id);
        echo $hasil->kodepos;
    }

    public function get_alamat()
    {
        $q = $this->input->get('q');
        $data['results'] = [];
        $p_kode = $_SESSION['id'];


        if (isset($q)) {
            $alamat = $this->pengguna_alamat->with_pengguna()->with_alamat()->where('pengguna_kode', $p_kode)->get_all();
            foreach ($alamat as $g) {
                $hasil = array();
                $hasil['provinsi'] = $this->provinsi
                    ->where('provinsi_id', $g->alamat->alamat_provinsi)
                    ->get()->provinsi_nama;
                $hasil['kabupaten'] = $this->kabupaten
                    ->where('kabupaten_id', $g->alamat->alamat_kabupaten)
                    ->get()->kabupaten_nama;
                $hasil['kecamatan'] = $this->kecamatan
                    ->where('kecamatan_id', $g->alamat->alamat_kecamatan)
                    ->get()->kecamatan_nama;

                $text = $g->alamat->alamat_deskripsi . ', ' . $hasil['kecamatan'] . ', ' . $hasil['kabupaten'] .
                    ', ' . $hasil['provinsi'] . ', ' . $g->alamat->alamat_kodepos;

                array_push($data['results'], array(
                    'id' => $g->alamat->alamat_kode,
                    'text' => $text
                ));
            }
        } else {
            $alamat = $this->pengguna_alamat->with_pengguna()->with_alamat()->where('pengguna_kode', $p_kode)->get_all();
            foreach ($alamat as $g) {
                $hasil = array();
                $hasil['provinsi'] = $this->provinsi
                    ->where('provinsi_id', $g->alamat->alamat_provinsi)
                    ->get()->provinsi_nama;
                $hasil['kabupaten'] = $this->kabupaten
                    ->where('kabupaten_id', $g->alamat->alamat_kabupaten)
                    ->get()->kabupaten_nama;
                $hasil['kecamatan'] = $this->kecamatan
                    ->where('kecamatan_id', $g->alamat->alamat_kecamatan)
                    ->get()->kecamatan_nama;


                $text = $g->alamat->alamat_deskripsi . ', ' . $hasil['kecamatan'] . ', ' . $hasil['kabupaten'] .
                    ', ' . $hasil['provinsi'] . ', ' . $g->alamat->alamat_kodepos;
                array_push($data['results'], array(
                    'id' => $g->alamat->alamat_kode,
                    'text' => $text
                ));
            }
        }


        echo json_encode($data);
    }

    public function get_full_alamat($id)
    {
        $g = $this->pengguna_alamat->with_alamat('where:alamat_kode = \'' . $id . '\'')->get_all();
        foreach ($g as $alamat) {
            $hasil = array(
                'pengguna_alamat_r_nama' => $alamat->pengguna_alamat_r_nama,
                'pengguna_alamat_r_kontak' => $alamat->pengguna_alamat_r_kontak,
                'pengguna_alamat_s_nama' => $alamat->pengguna_alamat_s_nama,
                'pengguna_alamat_s_kontak' => $alamat->pengguna_alamat_s_kontak,
                'alamat_kode' => $alamat->alamat->alamat_kode,
                'alamat_provinsi' => $alamat->alamat->alamat_provinsi,
                'alamat_kabupaten' => $alamat->alamat->alamat_kabupaten,
                'alamat_kecamatan' => $alamat->alamat->alamat_kecamatan,
                'alamat_desa' => $alamat->alamat->alamat_desa,
                'alamat_kodepos' => $alamat->alamat->alamat_kodepos,
                'alamat_deskripsi' => $alamat->alamat->alamat_deskripsi,
            );
        }

        echo json_encode($hasil);
    }

    public function get_last_img($i_kode)
    {
        $img = $this->item_img->where('i_kode', $i_kode)->limit(1)->order_by('created_at', 'ASC')->get();

        $hasil = array();
        $hasil['type'] = $img->ii_type;
        $hasil['img'] = base64_encode($img->ii_data);

        echo json_encode($hasil);
    }

    public function get_default_img($i_kode)
    {
        $img = $this->item_img->where(array('i_kode' => $i_kode))->order_by('created_at', 'DESC')->get();
        $hasil = array();
        $hasil['type'] = $img->ii_type;
        $hasil['img'] = base64_encode($img->ii_data);

        echo json_encode($hasil);
    }

}