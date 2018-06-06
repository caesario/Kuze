<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 11/03/2018
 * Time: 02.54
 */

class Item_img extends MY_Controller
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
        $this->data->title = 'Fashion Grosir | Foto';
        $this->data->title_page = 'Foto';
        $this->data->total_item_img = $this->item_img->count_rows();
        $this->data->item_imgs = $this->item_img->with_item_detil->get_all();
        $this->load->view('Foto', $this->data);
    }

    public function simpan()
    {
        // create object

        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $item_img = $this->item_img->where_p_kode($id)->get();

        if ($item_img) {
            $item_img = $this->item_img->where_i_kode($id)->update(array(
                'ii_nama' => $this->input->post('nama'),
                'ii_url' => $this->input->post('url'),
            ));

            $item_img_kategori = $this->item_img_kategori->where_i_kode($id)->update(array(
                'k_kode' => $this->input->post('kategori'),
            ));
            if ($item_img && $item_img_kategori) {
                $this->data->berhasil = 'Data Foto berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('item_img');
            } else {
                $this->data->gagal = 'Data Foto gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('item_img');
            }
        } else {
            $item_img = $this->item_img->insert(array(
                'i_kode' => $this->input->post('id'),
                'i_nama' => $this->input->post('nama'),
                'i_hrg_vip' => $this->input->post('harga_vip'),
                'i_hrg_reseller' => $this->input->post('harga_reseller'),
                'i_deskripsi' => $this->input->post('deskripsi'),
//                'created_by'      => $_SESSION['username'],
            ));

            $item_img_kategori = $this->item_img_kategori->insert(array(
                'item_img_kategori_kode' => $this->item_img_kategori->guid(),
                'i_kode' => $this->input->post('id'),
                'k_kode' => $this->input->post('kategori'),
            ));

            if ($item_img && $item_img_kategori) {
                $this->data->berhasil = 'Data Foto berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('item_img');
            } else {
                $this->data->gagal = 'Data Foto gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('item_img');
            }
        }
    }

    public function set_default($i_kode, $id)
    {
        $this->item_img->where_i_kode($i_kode)->update(array(
            'ii_default'     => 0
        ));

        $foto = $this->item_img->where_ii_kode($id)->update(array(
           'ii_default'     => 1
        ));

        if ($foto)
        {
            $this->data->berhasil = 'Data Foto berhasil diperbaharui';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('item');
        }
    }

    public function foto($i_kode)
    {
        $this->data->title = 'Fashion Grosir | Foto';
        $this->data->title_page = 'Foto';
        $this->data->item_imgs = $this->item_img->where('i_kode', $i_kode)->get_all();
        $this->data->i_kode = $i_kode;
        $this->load->view('Foto', $this->data);
    }

    public function unggah($i_kode)
    {
        $this->data->title = 'Fashion Grosir | Foto';
        $this->data->title_page = 'Foto';
        $this->data->i_kode = $i_kode;
        $this->load->view('CRUD_Foto', $this->data);
    }


    public function detil($id)
    {
        $this->data->title = 'Fashion Grosir | Foto > Detil';
        $this->data->item_img = $this->item_img->where('p_kode', $id)->get();
        $this->load->view('CRUD_Foto', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = 'Fashion Grosir | Foto > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->item_img = $this->item_img->where('p_kode', $id)->get();

        $this->load->view('CRUD_Foto', $this->data);
    }

    public function hapus($id)
    {

        $item_img = $this->item_img->where('ii_kode', $id)->delete();
        if ($item_img) {
            $this->data->berhasil = 'Data Foto berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('item');
        } else {
            $this->data->gagal = 'Data Foto gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('item');
        }
    }


}