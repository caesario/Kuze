<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class New_arrival extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data->items = $this->item->where('i_new', '1')->get_all();
        $this->data->breadcumburl = site_url('new_arrival');
        $this->data->breadcumb = 'New Arrival';
        $this->load->view('New_arrival', $this->data);
    }

    public function get_item_all()
    {
        $this->data->items = $this->item->limit(10)->get_all();
        $this->data->breadcumburl = site_url('category');
        $this->data->breadcumb = 'Kategori';
        $this->load->view('Kategori', $this->data);
    }

    public function get_item($k_url)
    {
        $kategori = $this->kategori->where('k_url', $k_url)->get();
        if ($kategori) {
            $item_kategori = $this->item_kategori
                ->where('k_kode', $kategori->k_kode)
                ->with_item()->get_all();
        } else {
            $item_kategori = '';
        }
        $this->data->k_url = $k_url;
        $this->data->item_kategori = $item_kategori;
        $this->data->breadcumburl = site_url('category/' . $k_url);
        $this->data->breadcumb = $this->category->where('k_url', $k_url)->get()->k_nama;
        $this->load->view('Kategori', $this->data);
    }

    public function get_item_detil($k_url, $i_url)
    {
        $this->data->item = $this->item
            ->with_item_detil()
            ->where('i_url', $i_url)
            ->get();
        $this->data->breadcumburl = site_url('category/' . $k_url);
        $this->data->breadcumburl1 = site_url('category/' . $k_url . '/item/' . $i_url . '/detil');
        $this->data->breadcumb = $this->category->where('k_url', $k_url)->get()->k_nama;
        $this->data->breadcumb1 = $this->item->where('i_url', $i_url)->get()->i_nama;
        $this->load->view('Detil', $this->data);
    }

    public function get_item_detil_all($i_url)
    {
        $this->data->item = $this->item
            ->with_item_detil()
            ->where('i_url', $i_url)
            ->get();
        $this->data->breadcumburl = site_url('category/all');
        $this->data->breadcumburl1 = site_url('category/all/item/' . $i_url . '/detil');
        $this->data->breadcumb = 'All';
        $this->data->breadcumb1 = $this->item->where('i_url', $i_url)->get()->i_nama;
        $this->load->view('Detil', $this->data);
    }

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */