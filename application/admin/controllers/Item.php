<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 11/03/2018
 * Time: 02.54
 */

class Item extends MY_Controller
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
            'field' => 'i_nama',
            'title' => 'title',
            'table' => 'item',
            'id' => 'i_id',
        );
        $this->load->library('slug', $config);

        $this->data->warna_all = $this->warna->get_all();
        $this->data->kategori_all = $this->kategori->get_all();
    }

    public function index()
    {
        $this->data->title = $this->data->brandname . ' | Item';
        $this->data->title_page = 'Item';

        $this->data->total_item = $this->item->count_rows();
        $this->data->items = $this->item->with_item_detil()->with_item_kategori()->get_all();
        $this->data->warna = function ($ide_kode, $w_kode) {
            return $this->warna->fields('w_nama')->with_item_detil('where:item_detil_kode = \'' . $ide_kode . '\'')->where('w_kode', $w_kode)->get();
        };

        $this->data->ukuran = function ($ide_kode, $u_kode) {
            return $this->ukuran->fields('u_nama')->with_item_detil('where:item_detil_kode = \'' . $ide_kode . '\'')->where('u_kode', $u_kode)->get();
        };

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

        $this->data->kategori = function ($i_kode) {
            $kategori = [];
            $item_kategori = $this->item_kategori->with_kategori()->where('i_kode', $i_kode)->get_all();
            if ($item_kategori != NULL) {
                foreach ($item_kategori as $kat) {
                    array_push($kategori, $kat->kategori->k_nama);
                }
            }


            return implode('<br>', $kategori);
        };

        $this->load->view('Item', $this->data);
    }



    public function by($kategori_kode)
    {
        $this->data->title = $this->data->brandname . ' | Item';
        $this->data->title_page = 'Item';
        $this->data->total_item = $this->item->count_rows();
        $this->data->items = $this->item->select_sum_qty_where($kategori_kode);
        $this->load->view('Item', $this->data);
    }


    public function simpan()
    {
        $this->form_validation->set_rules('nama', 'Item', 'is_unique[item.i_nama]', array('is_unique' => 'Terdapat nama yang sama. Silahkan coba lagi.'));

        // get guid form post
        $id = $this->input->post('id');
        $counter = (int)$this->input->post('counter');

        // get user from database where guid
        $item = $this->item->where('i_kode', $id)->get();
        $item_nama = $this->input->post('nama');
        $item_array = array(
            'i_kode' => $id,
            'i_nama' => $item_nama,
            'i_hrg' => $this->input->post('hrg'),
            'i_berat' => $this->input->post('berat'),
            'i_deskripsi' => $this->input->post('deskripsi'),
            'i_hot' => 0,
            'i_new' => $this->input->post('i_new') != '' ? $this->input->post('i_new') : 0,
            'i_best' => $this->input->post('i_best') != '' ? $this->input->post('i_best') : 0,
            'i_url' => $this->slug->create_uri(array('title' => $this->input->post('nama')))
        );

        // item
        if ($item) {

            // validasi
            if ($this->form_validation->run() === FALSE && $item->i_nama != $item_nama) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);
                redirect('item');
            } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $item_nama)) {
                $this->data->gagal = 'Karakter untuk item tidak diperbolehkan.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('item');
            }

            // update
            $item_update = $this->item->update($item_array, 'i_kode');

            $item_kategori_hapus = $this->item_kategori->where('i_kode', $id)->delete();

            if ($item_kategori_hapus) {
                if (isset($_POST['kategori'])) {
                    foreach ($this->input->post('kategori') as $kategori) {
                        $this->item_kategori->insert(array(
                            'ik_kode' => $this->item_kategori->guid(),
                            'i_kode' => $this->input->post('id'),
                            'k_kode' => $kategori,
                        ));
                    }
                }
            }


            if ($item_update) {
                $this->data->berhasil = 'Data Item berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('item');
            } else {
                $this->data->gagal = 'Data Item gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('item');
            }
        } else {

            if ($this->form_validation->run() === FALSE) {
                $this->data->gagal = validation_errors();
                $this->session->set_flashdata('gagal', $this->data->gagal);
                redirect('item');
            } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $item_nama)) {
                $this->data->gagal = 'Karakter untuk item tidak diperbolehkan.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('item');
            }

            // insert
            $item_insert = $this->item->insert($item_array);

            if (isset($_POST['kategori'])) {
                foreach ($this->input->post('kategori') as $kategori) {
                    $this->item_kategori->insert(array(
                        'ik_kode' => $this->item_kategori->guid(),
                        'i_kode' => $this->input->post('id'),
                        'k_kode' => $kategori,
                    ));
                }
            }

            for ($i = 0; $i < $counter; $i++) {
                $id_detil = $this->item_detil->guid();
                $item_detil = $this->item_detil->insert(array(
                    'item_detil_kode' => $id_detil,
                    'i_kode' => $this->input->post('id'),
                    'u_kode' => $_POST['ukuran'][$i],
                ));

                $item_qty = $this->item_qty->insert(array(
                    'iq_kode' => $this->item_qty->guid(),
                    'item_detil_kode' => $id_detil,
                    'iq_qty' => $_POST['qty'][$i]
                ));
            }


            if ($item_insert && $item_detil && $item_qty) {
                $this->data->berhasil = 'Data Item berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('item');
            } else {
                $this->data->gagal = 'Data Item gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('item');
            }
        }
    }

    public function tambah()
    {
        $this->data->title = $this->data->brandname . ' | Item > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->item->guid();

        $this->load->view('CRUD_Item', $this->data);
    }

    public function edit_item($id)
    {
        $this->data->title = $this->data->brandname . ' | Item > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->items = $this->item->where('i_kode', $id)->get();
        $this->data->kategori_selected = function ($k_kode, $i_kode)
        {
            $item_kategori = $this->item_kategori->where(array('k_kode' => $k_kode, 'i_kode' => $i_kode))->get();
            if ($item_kategori) {
                $selected = 'selected';
            } else {
                $selected = '';
            }

            return $selected;

        };

        $this->load->view('CRUD_Item', $this->data);
    }

    public function tambah_detil($id)
    {
        $this->data->title = $this->data->brandname . ' | Item > Tambah Detail';
        $this->data->submit = 'Tambah Detail';
        $this->data->items = $this->item->where('i_kode', $id)->get();

        $this->load->view('CRUD_Item', $this->data);
    }

    public function tambah_qty($id)
    {
        $this->data->title = $this->data->brandname . ' | Item > Tambah QTY';
        $this->data->submit = 'Tambah QTY';
        $this->data->kode = $id;
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->load->view('CRUD_Item_QTY', $this->data);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $qty = $this->item_qty->insert(array(
                'iq_kode' => $this->item_qty->guid(),
                'iq_qty' => $this->input->post('qty'),
                'item_detil_kode' => $this->input->post('id')
            ));

            if ($qty) {
                $this->data->berhasil = 'Stok telah berhasil ditambahkan.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('item');
            } else {
                $this->data->gagal = 'Stok telah gagal ditambahkan.';
                $this->session->set_flashdata('berhasil', $this->data->gagal);

                redirect('item');
            }
        }

    }

    public function detil($id)
    {
        $this->data->title = $this->data->brandname . ' | Item > Detail';
        $this->data->item = $this->item->where('pengguna_kode', $id)->get();
        $this->load->view('CRUD_Item', $this->data);
    }

    public function ubah_detil($id)
    {
        $this->data->title = $this->data->brandname . ' | Item > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->item_detil = $this->item_detil->where('item_detil_kode', $id)->get();

        $this->load->view('CRUD_Item_detil', $this->data);
    }

    public function simpan_detil()
    {
        $id = $this->input->post('id');

        $item_detil = $this->item_detil
            ->where('item_detil_kode', $id)
            ->update(array(
                'w_kode' => $this->input->post('warna'),
                'u_kode' => $this->input->post('ukuran'),
            ));

        if ($item_detil) {
            $this->data->berhasil = 'Detail item berhasil diubah.';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('item');
        } else {
            $this->data->gagal = 'Detail item gagal diubah.';
            $this->session->set_flashdata('gagal', $this->data->gagal);

            redirect('item');
        }
    }

    public function tambah_detil_simpan()
    {
        $id = $this->input->post('id');
        $counter = (int)$this->input->post('counter');

        for ($i = 0; $i < $counter; $i++) {
            $id_detil = $this->item_detil->guid();
            $item_detil = $this->item_detil->insert(array(
                'item_detil_kode' => $id_detil,
                'i_kode' => $id,
                'w_kode' => $_POST['warna'][$i],
                'u_kode' => $_POST['ukuran'][$i],
            ));

            $item_qty = $this->item_qty->insert(array(
                'iq_kode' => $this->item_qty->guid(),
                'item_detil_kode' => $id_detil,
                'iq_qty' => $_POST['qty'][$i]
            ));
        }

        if ($item_detil && $item_qty)
        {
            $this->data->berhasil = 'Item detil berhasil ditambah';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('item');
        } else {
            $this->data->gagal = 'Item detil gagal ditambah';
            $this->session->set_flashdata('gagal', $this->data->gagal);

            redirect('item');
        }

    }

    public function hapus($id)
    {

        $item_detil = $this->item_detil->where('item_detil_kode', $id)->delete();
        if ($item_detil) {
            $this->data->berhasil = 'Data Item berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('item');
        } else {
            $this->data->gagal = 'Data Item gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('item');
        }
    }

    public function hapus_item($id)
    {

        $item = $this->item->where('i_kode', $id)->delete();
        if ($item) {
            $this->data->berhasil = 'Data Item berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('item');
        } else {
            $this->data->gagal = 'Data Item gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('item');
        }
    }

}