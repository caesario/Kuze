<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 08/03/2018
 * Time: 00.07
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends MY_Controller
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
        $this->load->helper(array('form', 'url'));

    }

    public function do_upload()
    {
        $files = array();
        $counter = count($_FILES['images']['size']);
        echo $counter;
        for($i=0; $i < $counter ; $i++)
        {
            // cek update
            $img = $this->item_img->where(array('i_kode' => $this->input->post('i_kode'), 'ii_default' => 1))->get();

            if (!$img) {
                $default = 1;
            } else {
                $default = 0;
            }

            $_FILES['image']['name']= $_FILES['images']['name'][$i];
            $_FILES['image']['type']= $_FILES['images']['type'][$i];
            $_FILES['image']['tmp_name']= $_FILES['images']['tmp_name'][$i];
            $_FILES['image']['error']= $_FILES['images']['error'][$i];
            $_FILES['image']['size']= $_FILES['images']['size'][$i];

            //upload an image options
            $config = array();
            $config['upload_path'] = './upload';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = '0';
            $config['overwrite']     = TRUE;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->do_upload('image');
            $files[] = $this->upload->data();

            $data = array(
                'ii_kode'       => $this->item_img->guid(),
                'ii_nama'       => $files[$i]['file_name'],
                'ii_url'       => $files[$i]['file_name'],
                'ii_default' => $default,
                'ii_type' => $files[$i]['image_type'],
                'i_kode'        => $this->input->post('i_kode')
            );

            // insert
            $this->item_img->insert($data);
        }

        $this->data->berhasil = 'Foto Item berhasil diperbarui.';
        $this->session->set_flashdata('berhasil', $this->data->berhasil);

        redirect('item');

//        echo json_encode($files);
    }

    public function multiple_image()
    {
        $files = array();
        $counter = count($_FILES['images']['size']);
        for ($i = 0; $i < $counter; $i++) {
            $_FILES['image']['name'] = $_FILES['images']['name'][$i];
            $_FILES['image']['type'] = $_FILES['images']['type'][$i];
            $_FILES['image']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
            $_FILES['image']['error'] = $_FILES['images']['error'][$i];
            $_FILES['image']['size'] = $_FILES['images']['size'][$i];

            //upload an image options
            $config = array();
            $config['upload_path'] = './upload';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '0';
            $config['overwrite'] = TRUE;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->do_upload('image');
            $files[] = $this->upload->data();
        }

//        echo json_encode($files);
    }

    public function single_image()
    {
        //upload an image options
        $config = array();
        $config['upload_path'] = './upload';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '0';
        $config['overwrite'] = TRUE;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->do_upload('image');
        $hasil = $this->upload->data();

//        echo json_encode($hasil);
    }


}
