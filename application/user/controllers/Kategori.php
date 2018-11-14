<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $this->data->items = $this->item->limit(10)->get_all();
        $this->data->breadcumburl = site_url('kategori');
        $this->data->breadcumb = 'Category';
        $this->load->view('Kategori', $this->data);
    }

    public function get_item_all()
    {
        $this->data->items = $this->item->limit(10)->get_all();
        $this->data->breadcumburl = site_url('kategori');
        $this->data->breadcumb = 'Kategori';
        $this->load->view('Kategori', $this->data);
    }

    public function get_item($k_url)
    {
        $item_kategori = function () use ($k_url) {
            $kategori_kode = $this->kategori->where('k_url', $k_url)->get()->k_kode;
            $hasil = $this->item_kategori->with_item()->where('k_kode', $kategori_kode)->get_all();

            if ($hasil) {
                return $hasil;
            } else {
                return $hasil = NULL;
            }
        };
        $this->data->k_url = $k_url;
        $this->data->item_kategori = $item_kategori();
        $this->data->breadcumburl = site_url('category/' . $k_url);
        $this->data->breadcumb = $this->kategori->where('k_url', $k_url)->get()->k_nama;
        $this->load->view('Kategori', $this->data);
//        print_r($item_kategori());
    }

    public function get_item_detil($k_url, $i_url)
    {

        $this->data->item = $this->item
            ->with_item_detil()
            ->where('i_url', $i_url)
            ->get();
        $item_detils = function () use ($i_url) {
            $counter = 0;
            $hasil = array();
            $item_detils = $this->item_detil->with_item('where: i_url=\'' . $i_url . '\'')->with_ukuran()->with_item_qty()->get_all();
            foreach ($item_detils as $id) {
                if (isset($id->item) && $id->item != NULL) {
                    $hasil[$counter]['item_kode'] = $id->item->i_kode;
                    $hasil[$counter]['item_nama'] = $id->item->i_nama;
                } else {
                    $hasil[$counter]['item_kode'] = NULL;
                    $hasil[$counter]['item_nama'] = NULL;
                }
                $hasil[$counter]['item_detil_kode'] = $id->item_detil_kode;
                if (isset($id->ukuran) && $id->ukuran != NULL) {
                    $hasil[$counter]['ukuran_kode'] = $id->ukuran->u_kode;
                    $hasil[$counter]['ukuran_nama'] = $id->ukuran->u_nama;
                } else {
                    $hasil[$counter]['ukuran_kode'] = 'NULL';
                    $hasil[$counter]['ukuran_nama'] = 'NULL';
                }

                if (isset($id->item_qty) && $id->item_qty != NULL) {
                    $qty = 0;
                    foreach ($id->item_qty as $iqty) {
                        $qty += $iqty->iq_qty;
                    }
                    $hasil[$counter]['ukuran_qty'] = $qty;
                } else {
                    $hasil[$counter]['ukuran_qty'] = 0;
                }

                $counter += 1;


            }

            return $hasil;
        };

//        echo '<pre>';
//        var_dump($item_detils());
//        echo '</pre>';
        $this->data->item_detils = $item_detils();
        $this->data->breadcumburl = site_url('category/' . $k_url);
        $this->data->breadcumburl1 = site_url('category/' . $k_url . '/item/' . $i_url . '/detil');
        $this->data->breadcumb = $this->kategori->where('k_url', $k_url)->get()->k_nama;
        $this->data->breadcumb1 = $this->item->where('i_url', $i_url)->get()->i_nama;
        $this->load->view('Detil', $this->data);
    }

    public function get_item_detil_all($i_url)
    {
        $this->data->item = $this->item
            ->with_item_detil()
            ->where('i_url', $i_url)
            ->get();
        $item_detils = function () use ($i_url) {
            $counter = 0;
            $hasil = array();
            $item_detils = $this->item_detil->with_item('where: i_url=\'' . $i_url . '\'')->with_ukuran()->with_item_qty()->get_all();
            foreach ($item_detils as $id) {
                if (isset($id->item) && $id->item != NULL) {
                    $hasil[$counter]['item_kode'] = $id->item->i_kode;
                    $hasil[$counter]['item_nama'] = $id->item->i_nama;
                } else {
                    $hasil[$counter]['item_kode'] = NULL;
                    $hasil[$counter]['item_nama'] = NULL;
                }
                $hasil[$counter]['item_detil_kode'] = $id->item_detil_kode;
                if (isset($id->ukuran) && $id->ukuran != NULL) {
                    $hasil[$counter]['ukuran_kode'] = $id->ukuran->u_kode;
                    $hasil[$counter]['ukuran_nama'] = $id->ukuran->u_nama;
                } else {
                    $hasil[$counter]['ukuran_kode'] = 'NULL';
                    $hasil[$counter]['ukuran_nama'] = 'NULL';
                }

                if (isset($id->item_qty) && $id->item_qty != NULL) {
                    $qty = 0;
                    foreach ($id->item_qty as $iqty) {
                        $qty += $iqty->iq_qty;
                    }
                    $hasil[$counter]['ukuran_qty'] = $qty;
                } else {
                    $hasil[$counter]['ukuran_qty'] = 0;
                }

                $counter += 1;


            }

            return $hasil;
        };

//        echo '<pre>';
//        var_dump($item_detils());
//        echo '</pre>';
        $this->data->item_detils = $item_detils();
        $this->data->breadcumburl = site_url('category/all');
        $this->data->breadcumburl1 = site_url('category/all/item/' . $i_url . '/detil');
        $this->data->breadcumb = 'All';
        $this->data->breadcumb1 = $this->item->where('i_url', $i_url)->get()->i_nama;
        $this->load->view('Detil', $this->data);
    }

    public function get_item_bestseller($i_url)
    {
        $this->data->item = $this->item
            ->with_item_detil()
            ->where('i_url', $i_url)
            ->get();
        $item_detils = function () use ($i_url) {
            $counter = 0;
            $hasil = array();
            $item_detils = $this->item_detil->with_item('where: i_url=\'' . $i_url . '\'')->with_ukuran()->with_item_qty()->get_all();
            if ($item_detils) {
                foreach ($item_detils as $id) {
                    if (isset($id->item) && $id->item != NULL) {
                        $hasil[$counter]['item_kode'] = $id->item->i_kode;
                        $hasil[$counter]['item_nama'] = $id->item->i_nama;
                    } else {
                        $hasil[$counter]['item_kode'] = NULL;
                        $hasil[$counter]['item_nama'] = NULL;
                    }
                    $hasil[$counter]['item_detil_kode'] = $id->item_detil_kode;
                    if (isset($id->ukuran) && $id->ukuran != NULL) {
                        $hasil[$counter]['ukuran_kode'] = $id->ukuran->u_kode;
                        $hasil[$counter]['ukuran_nama'] = $id->ukuran->u_nama;
                    } else {
                        $hasil[$counter]['ukuran_kode'] = 'NULL';
                        $hasil[$counter]['ukuran_nama'] = 'NULL';
                    }

                    if (isset($id->item_qty) && $id->item_qty != NULL) {
                        $qty = 0;
                        foreach ($id->item_qty as $iqty) {
                            $qty += $iqty->iq_qty;
                        }
                        $hasil[$counter]['ukuran_qty'] = $qty;
                    } else {
                        $hasil[$counter]['ukuran_qty'] = 0;
                    }

                    $counter += 1;


                }
            }

            return $hasil;
        };

        $this->data->item_detils = $item_detils();
        $this->data->breadcumburl = site_url('best_seller');
        $this->data->breadcumburl1 = site_url('best_seller/item/' . $i_url . '/detil');
        $this->data->breadcumb = 'Best Seller';
        $this->data->breadcumb1 = $this->item->where('i_url', $i_url)->get()->i_nama;
        $this->load->view('Detil', $this->data);
    }

    public function get_item_newarrival($i_url)
    {
        $this->data->item = $this->item
            ->with_item_detil()
            ->where('i_url', $i_url)
            ->get();
        $item_detils = function () use ($i_url) {
            $counter = 0;
            $hasil = array();
            $item_detils = $this->item_detil->with_item('where: i_url=\'' . $i_url . '\'')->with_ukuran()->with_item_qty()->get_all();
            foreach ($item_detils as $id) {
                if (isset($id->item) && $id->item != NULL) {
                    $hasil[$counter]['item_kode'] = $id->item->i_kode;
                    $hasil[$counter]['item_nama'] = $id->item->i_nama;
                } else {
                    $hasil[$counter]['item_kode'] = NULL;
                    $hasil[$counter]['item_nama'] = NULL;
                }
                $hasil[$counter]['item_detil_kode'] = $id->item_detil_kode;
                if (isset($id->ukuran) && $id->ukuran != NULL) {
                    $hasil[$counter]['ukuran_kode'] = $id->ukuran->u_kode;
                    $hasil[$counter]['ukuran_nama'] = $id->ukuran->u_nama;
                } else {
                    $hasil[$counter]['ukuran_kode'] = 'NULL';
                    $hasil[$counter]['ukuran_nama'] = 'NULL';
                }

                if (isset($id->item_qty) && $id->item_qty != NULL) {
                    $qty = 0;
                    foreach ($id->item_qty as $iqty) {
                        $qty += $iqty->iq_qty;
                    }
                    $hasil[$counter]['ukuran_qty'] = $qty;
                } else {
                    $hasil[$counter]['ukuran_qty'] = 0;
                }

                $counter += 1;


            }

            return $hasil;
        };

        $this->data->item_detils = $item_detils();
        $this->data->breadcumburl = site_url('new_arrival');
        $this->data->breadcumburl1 = site_url('new_arrival/item/' . $i_url . '/detil');
        $this->data->breadcumb = 'New Arrival';
        $this->data->breadcumb1 = $this->item->where('i_url', $i_url)->get()->i_nama;
        $this->load->view('Detil', $this->data);
    }

    public function get_item_saleitem($i_url)
    {
        $this->data->item = $this->item
            ->with_item_detil()
            ->where('i_url', $i_url)
            ->get();
        $item_detils = function () use ($i_url) {
            $counter = 0;
            $hasil = array();
            $item_detils = $this->item_detil->with_item('where: i_url=\'' . $i_url . '\'')->with_ukuran()->with_item_qty()->get_all();
            foreach ($item_detils as $id) {
                if (isset($id->item) && $id->item != NULL) {
                    $hasil[$counter]['item_kode'] = $id->item->i_kode;
                    $hasil[$counter]['item_nama'] = $id->item->i_nama;
                } else {
                    $hasil[$counter]['item_kode'] = NULL;
                    $hasil[$counter]['item_nama'] = NULL;
                }
                $hasil[$counter]['item_detil_kode'] = $id->item_detil_kode;
                if (isset($id->ukuran) && $id->ukuran != NULL) {
                    $hasil[$counter]['ukuran_kode'] = $id->ukuran->u_kode;
                    $hasil[$counter]['ukuran_nama'] = $id->ukuran->u_nama;
                } else {
                    $hasil[$counter]['ukuran_kode'] = 'NULL';
                    $hasil[$counter]['ukuran_nama'] = 'NULL';
                }

                if (isset($id->item_qty) && $id->item_qty != NULL) {
                    $qty = 0;
                    foreach ($id->item_qty as $iqty) {
                        $qty += $iqty->iq_qty;
                    }
                    $hasil[$counter]['ukuran_qty'] = $qty;
                } else {
                    $hasil[$counter]['ukuran_qty'] = 0;
                }

                $counter += 1;


            }

            return $hasil;
        };

//        echo '<pre>';
//        var_dump($item_detils());
//        echo '</pre>';
        $this->data->item_detils = $item_detils();
        $this->data->breadcumburl = site_url('sale_item');
        $this->data->breadcumburl1 = site_url('sale_item/item/' . $i_url . '/detil');
        $this->data->breadcumb = 'Sale Item';
        $this->data->breadcumb1 = $this->item->where('i_url', $i_url)->get()->i_nama;
        $this->load->view('Detil', $this->data);
    }

    public function get_hot_item($i_url)
    {
        $this->data->item = $this->item
            ->with_item_detil()
            ->where('i_url', $i_url)
            ->get();
        $item_detils = function () use ($i_url) {
            $counter = 0;
            $hasil = array();
            $item_detils = $this->item_detil->with_item('where: i_url=\'' . $i_url . '\'')->with_ukuran()->with_item_qty()->get_all();
            foreach ($item_detils as $id) {
                if (isset($id->item) && $id->item != NULL) {
                    $hasil[$counter]['item_kode'] = $id->item->i_kode;
                    $hasil[$counter]['item_nama'] = $id->item->i_nama;
                } else {
                    $hasil[$counter]['item_kode'] = NULL;
                    $hasil[$counter]['item_nama'] = NULL;
                }
                $hasil[$counter]['item_detil_kode'] = $id->item_detil_kode;
                if (isset($id->ukuran) && $id->ukuran != NULL) {
                    $hasil[$counter]['ukuran_kode'] = $id->ukuran->u_kode;
                    $hasil[$counter]['ukuran_nama'] = $id->ukuran->u_nama;
                } else {
                    $hasil[$counter]['ukuran_kode'] = 'NULL';
                    $hasil[$counter]['ukuran_nama'] = 'NULL';
                }

                if (isset($id->item_qty) && $id->item_qty != NULL) {
                    $qty = 0;
                    foreach ($id->item_qty as $iqty) {
                        $qty += $iqty->iq_qty;
                    }
                    $hasil[$counter]['ukuran_qty'] = $qty;
                } else {
                    $hasil[$counter]['ukuran_qty'] = 0;
                }

                $counter += 1;


            }

            return $hasil;
        };

        $this->data->item_detils = $item_detils();
        $this->data->breadcumburl = site_url('hot_item');
        $this->data->breadcumburl1 = site_url('hot_item/item/' . $i_url . '/detil');
        $this->data->breadcumb = 'Hot Item';
        $this->data->breadcumb1 = $this->item->where('i_url', $i_url)->get()->i_nama;
        $this->load->view('Detil', $this->data);
    }



}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */