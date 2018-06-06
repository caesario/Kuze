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
        $this->data->ukuran_all = $this->ukuran->get_all();
        $this->data->kategori_all = $this->kategori->get_all();
    }

    public function index()
    {
        $this->data->title = 'Fashion Grosir | Item';
        $this->data->title_page = 'Item';

        $this->data->total_item = $this->item->count_rows();
        $this->data->items = $this->item->with_item_detil()->with_item_kategori()->get_all();
        $this->data->warna = function ($ide_kode, $w_kode) {
            return $this->warna->fields('w_nama')->with_item_detil('where:ide_kode = \'' . $ide_kode . '\'')->where_w_kode($w_kode)->get();
        };

        $this->data->ukuran = function ($ide_kode, $u_kode) {
            return $this->ukuran->fields('u_nama')->with_item_detil('where:ide_kode = \'' . $ide_kode . '\'')->where_u_kode($u_kode)->get();
        };

        $this->data->seri = function ($ide_kode, $s_kode) {
            return $this->seri->fields('s_nama')->with_item_detil('where:ide_kode = \'' . $ide_kode . '\'')->where_s_kode($s_kode)->get();
        };

        $this->data->qty = function ($ide_kode) {
            $hasil = 0;
            $stoks = $this->item_qty->fields('iq_qty')->with_item_detil('where:ide_kode = \'' . $ide_kode . '\'')->get_all();
            foreach ($stoks as $stok) {
                $hasil += $stok->iq_qty;
            }

            return $hasil;
        };

        $this->data->kategori = function ($i_kode) {
            $kategori = [];
            foreach ($this->item_kategori->with_kategori()->where_i_kode($i_kode)->get_all() as $kat) {
                array_push($kategori, $kat->kategori->k_nama);
            }

            return implode('<br>', $kategori);
        };

        $this->load->view('Item', $this->data);
    }

    public function by($kategori_kode)
    {
        $this->data->title = 'Fashion Grosir | Item';
        $this->data->title_page = 'Item';
        $this->data->total_item = $this->item->count_rows();
        $this->data->items = $this->item->select_sum_qty_where($kategori_kode);
        $this->load->view('Item', $this->data);
    }


    public function simpan()
    {
        // create object

        // get guid form post
        $id = $this->input->post('id');
        $counter = (int)$this->input->post('counter');

        // get user from database where guid
        $item = $this->item->where_i_kode($id)->get();

        if ($item) {
            $item = $this->item->where_i_kode($id)->update(array(
                'i_nama' => $this->input->post('nama'),
                'i_hrg_vip' => $this->input->post('hrg_vip'),
                'i_hrg_reseller' => $this->input->post('hrg_reseller'),
                'i_berat' => $this->input->post('berat'),
                'i_deskripsi' => $this->input->post('deskripsi'),
                'i_url'     => $this->slug->create_uri(array('title' => $this->input->post('nama')))
            ));

            $item_kategori = $this->item_kategori->where_i_kode($id)->update(array(
                'k_kode' => $this->input->post('kategori'),
            ));
            if ($item && $item_kategori) {
                $this->data->berhasil = 'Data Item berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('item');
            } else {
                $this->data->gagal = 'Data Item gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('item');
            }
        } else {
            $item = $this->item->insert(array(
                'i_kode' => $this->input->post('id'),
                'i_nama' => $this->input->post('nama'),
                'i_hrg_vip' => $this->input->post('hrg_vip'),
                'i_hrg_reseller' => $this->input->post('hrg_reseller'),
                'i_berat' => $this->input->post('berat'),
                'i_deskripsi' => $this->input->post('deskripsi'),
                'i_url'     => $this->slug->create_uri(array('title' => $this->input->post('nama')))
            ));


            foreach ($this->input->post('kategori') as $kategori) {
                $item_kategori = $this->item_kategori->insert(array(
                    'ik_kode' => $this->item_kategori->guid(),
                    'i_kode' => $this->input->post('id'),
                    'k_kode' => $kategori,
                ));
            }

            for ($i = 0; $i < $counter; $i++) {
                $id_detil = $this->item_detil->guid();
                $item_detil = $this->item_detil->insert(array(
                    'ide_kode' => $id_detil,
                    'i_kode' => $this->input->post('id'),
                    'w_kode' => $_POST['warna'][$i],
                    's_kode' => $_POST['seri'][$i],
                    'u_kode' => $_POST['ukuran'][$i],
                ));

                $item_qty = $this->item_qty->insert(array(
                    'iq_kode' => $this->item_qty->guid(),
                    'ide_kode' => $id_detil,
                    'iq_qty' => $_POST['qty'][$i]
                ));
            }


            if ($item && $item_kategori && $item_detil && $item_qty) {
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
        $this->data->title = 'Fashion Grosir | Item > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->item->guid();

        $this->load->view('CRUD_Item', $this->data);
    }

    public function tambah_qty($id)
    {
        $this->data->title = 'Fashion Grosir | Item > Tambah QTY';
        $this->data->submit = 'Tambah QTY';
        $this->data->kode = $id;
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->load->view('CRUD_Item_QTY', $this->data);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $qty = $this->item_qty->insert(array(
                'iq_kode' => $this->item_qty->guid(),
                'iq_qty' => $this->input->post('qty'),
                'ide_kode' => $this->input->post('id')
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
        $this->data->title = 'Fashion Grosir | Item > Detil';
        $this->data->item = $this->item->where('p_kode', $id)->get();
        $this->load->view('CRUD_Item', $this->data);
    }

    public function ubah_detil($id)
    {
        $this->data->title = 'Fashion Grosir | Item > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->item_detil = $this->item_detil->where('ide_kode', $id)->get();

        $this->load->view('CRUD_Item_detil', $this->data);
    }

    public function simpan_detil()
    {
        $id = $this->input->post('id');

        $item_detil = $this->item_detil
            ->where('ide_kode', $id)
            ->update(array(
                'w_kode' => $this->input->post('warna'),
                'u_kode' => $this->input->post('ukuran'),
                's_kode' => $this->input->post('seri')
            ));

        if ($item_detil) {
            $this->data->berhasil = 'Detil item berhasil diubah.';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('item');
        } else {
            $this->data->gagal = 'Detil item gagal diubah.';
            $this->session->set_flashdata('gagal', $this->data->gagal);

            redirect('item');
        }
    }

    public function hapus($id)
    {

        $item_detil = $this->item_detil->where('ide_kode', $id)->delete();
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