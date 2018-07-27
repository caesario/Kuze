<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Seri extends MY_Controller
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
            'field' => 's_nama',
            'title' => 'title',
            'table' => 'seri',
            'id' => 's_id',
        );
        $this->load->library('slug', $config);
    }

    public function index()
    {
        $this->data->title = $this->data->brandname . ' | Nomor Seri';
        $this->data->title_page = 'Nomor Seri';
        $this->data->total_seri = $this->seri->count_rows();
        $this->data->seris = $this->seri->get_all();
        $this->load->view('Seri', $this->data);
    }

    public function tambah()
    {
        $this->data->title = $this->data->brandname . ' | Nomor Seri > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->seri->guid();

        $this->data->items = $this->item->with_item_detil()->with_item_kategori()->get_all();
        $this->data->warna = function ($ide_kode, $w_kode) {
            return $this->warna->fields('w_nama')->with_item_detil('where:item_detil_kode = \'' . $ide_kode . '\'')->where('w_kode', $w_kode)->get();
        };

//        $this->data->ukuran = function ($ide_kode, $u_kode) {
//            return $this->ukuran->fields('u_nama')->with_item_detil('where:item_detil_kode = \'' . $ide_kode . '\'')->where('u_kode', $u_kode)->get();
//        };

        $this->data->seri = function ($ide_kode, $s_kode) {
            return $this->seri->fields('s_nama')->with_item_detil('where:item_detil_kode = \'' . $ide_kode . '\'')->where('s_kode', $s_kode)->get();
        };

        $this->data->qty = function ($ide_kode) {
            $hasil = 0;
            $stoks = $this->item_detil->where('item_detil_kode', $ide_kode)->with_item_qty()->get();
            foreach ($stoks->item_qty as $stok) {
                $hasil += $stok->iq_qty;
            }

            return $hasil;
        };
        $this->load->view('CRUD_Seri', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = $this->data->brandname . ' | Nomor Seri > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->seris = $this->seri->where('s_kode', $id)->get();

        $this->load->view('CRUD_Seri', $this->data);
    }

    public function simpan()
    {
        $this->form_validation->set_rules('nama','Seri','is_unique[seri.s_nama]', array('is_unique' => 'Terdapat nama yang sama. Silahkan coba lagi.'));

        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $seri = $this->seri->where_s_kode($id)->get();
        $seri_nama = $this->input->post('nama');
        $seri_array = array(
            's_kode' => $id,
            's_nama' => $seri_nama,
            's_url' => $this->slug->create_uri(array('title' => $this->input->post('nama'))),
            's_image' => $this->input->post('image')
        );


        if ($seri) {

            if ($this->form_validation->run() === FALSE && $seri->s_nama != $seri_nama) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('seri');
            } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $seri_nama)) {
                $this->data->gagal = 'Karakter untuk nomor seri tidak diperbolehkan.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('seri');
            }

            // update
            $seri_update = $this->seri->update($seri_array, 's_kode');
            if ($seri_update) {
                $this->data->berhasil = 'Nomor Seri berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('seri');
            } else {
                $this->data->gagal = 'Nomor Seri gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('seri');
            }
        } else {

            // validasi
            if ($this->form_validation->run() === FALSE) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('seri');
            } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $seri_nama)) {
                $this->data->gagal = 'Karakter untuk nomor seri tidak diperbolehkan.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('seri');
            }

            // insert
            $seri_insert = $this->seri->insert($seri_array);
            if ($seri_insert) {
                $this->data->berhasil = 'Nomor Seri berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('seri');
            } else {
                $this->data->gagal = 'Nomor Seri gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('seri');
            }
        }
    }

    public function hapus($id)
    {
        $item_seri = $this->item_seri->where('s_kode', $id)->get();

        if ($item_seri)
        {
            $this->data->gagal = 'Nomor Seri tidak boleh dihapus karena masih digunakan.';
            $this->session->set_flashdata('gagal', $this->data->gagal);

            redirect('seri');
        }
        else
        {
            $seri = $this->seri->where('s_kode', $id)->delete();
            if ($seri) {
                $this->data->berhasil = 'Nomor Seri berhasil dihapus';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('seri');
            } else {
                $this->data->gagal = 'Nomor Seri gagal dihapus';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('seri');
            }
        }

    }

    public function get($item)
    {
        $this->data->members = $this->seri->many_to_many_where($item);
        $this->load->view('Tabel_detil', $this->data);
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
        $this->upload->do_upload('s_image');
        $hasil = $this->upload->data();

        return $hasil;
    }
}