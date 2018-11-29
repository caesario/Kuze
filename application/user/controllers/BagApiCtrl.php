<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BagApiCtrl extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->isonline) {
            echo json_encode('Session timeout', true);
            exit();
        }
    }

    public function bag_index()
    {
        $bags = function () {
            $bags = $this->cart->where('pengguna_kode', $_SESSION['id'])->get_all();

            if ($bags) {
                foreach ($bags as $bag) {
                    $item_detil = $this->item_detil->where('item_detil_kode', $bag->item_detil_kode)->get();

                    // item
                    $item = $this->item->where('i_kode', $item_detil->i_kode)->get();
                    if ($item) {
                        $bag->nama = $item->i_nama;
                    } else {
                        $bag->nama = '';
                    }

                    // item_img
                    $item_img = $this->item_img->where(array(
                        'i_kode' => $item_detil->i_kode
                    ))->get();
                    if ($item_img) {
                        $bag->image_id = $item_img->ii_kode;
                        $bag->image_data = 'data:' . $item_img->ii_type . ';base64,' . (base64_encode($item_img->ii_data));
                    } else {
                        $bag->image_id = 'No Image';
                        $bag->image_data = base_url('assets/img/noimage.jpg');
                    }

                    // item ukuran
                    $ukuran = $this->ukuran->where('u_kode', $item_detil->u_kode)->get();
                    if ($ukuran) {
                        $bag->ukuran = $ukuran->u_nama;
                    } else {
                        $bag->ukuran = '';
                    }

                    $bag->bag_delete = site_url('bag/' . $bag->ca_kode . '/delete');


                    unset($bag->item_kode);
                    unset($bag->item_detil_kode);
                    unset($bag->item_ukuran_kode);
                }
            }

            return $bags;
        };

        $total = function () {
            $hasil = 0;
            $carts = $this->cart->where('pengguna_kode', $_SESSION['id'])->get_all();
            if ($carts) {
                foreach ($carts as $cart_total) {
                    $hasil += (int)$cart_total->ca_tharga;
                }
            } else {
                $hasil = 0;
            }


            return (int)$hasil;
        };

        $grand_total = function () use ($total) {
            return $total();
        };

        $resp = array();

        $resp['bags'] = $bags();
        $resp['bags_total'] = $total();
        $resp['bags_grand_total'] = $grand_total();

        echo json_encode($resp, true);
    }

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */