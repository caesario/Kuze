<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testing extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $toko = $this->toko->get();
        $toko_array = array(
            't_kode' => 0,
            't_nama' => $this->randomString(10),
            't_singkatan' => $this->randomString(2),
            't_url' => $this->randomString(10),
            't_provinsi' => 12,
            't_kabupaten' => 1201,
            't_kecamatan' => 1201060,
            't_desa' => 1201060015,
            't_kodepos' => 22872,
            't_alamat' => $this->randomString(50),
            't_email' => 'testing@eazy-dev.xyz',
            't_line' => $this->randomString(5),
            't_insta' => $this->randomString(5),
            't_wa' => rand(12, 12),

        );
        if (!$toko) {
            $this->toko->insert($toko_array);
        }

        $check = $this->pengguna->where('pengguna_kode', 0)->get();
        if (!$check) {
            $this->pengguna->insert(array(
                'pengguna_kode' => 0,
                'pengguna_nama' => 'Super User',
                'pengguna_username' => 'eazy',
                'pengguna_password' => 'eazy9090',
                'pengguna_email' => 'super@eazy-dev.xyz',
                'pengguna_ipaddr' => '1.1.1.1',
                'pengguna_isaktif' => 1
            ));
        }
    }

    private function randomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generate($data = 10)
    {
        echo '<p>Kategori :';
        $this->kategori($data);
        echo '</p><p>Warna :';
        $this->warna($data);
        echo '</p><p>Ukuran :';
        $this->ukuran($data);
        echo '</p><p>Seri :';
        $this->seri($data);
        echo '</p><p>Item :';
        $this->item($data);
        echo '</p><p>Bank :';
        $this->bank($data);
        echo '</p><p>Artikel :';
        $this->artikel($data);
        echo '</p><p>Resi :';
        $this->resi($data);
        echo '</p><p>Pengguna :';
        $this->pengguna($data);
        echo '</p><p>Cart :';
        $this->cart($data);
        echo '</p><p>Order :';
        $this->order($data);
        echo '</p>';
    }

    private function kategori($data = 10)
    {
        $config = array(
            'field' => 'k_nama',
            'title' => 'title',
            'table' => 'kategori',
            'id' => 'k_id',
        );
        $this->load->library('slug', $config);


        for ($i = 1; $i <= $data; $i++) {
            $kategori_nama = $this->randomString(5);
            $kategori_array = array(
                'k_kode' => $this->kategori->guid(),
                'k_nama' => $kategori_nama,
                'k_url' => $this->slug->create_uri(array('title' => $kategori_nama))
            );

            $kategori = $this->kategori->insert($kategori_array);

            if ($kategori) {
                echo '<ul>';
                echo '<li>Testing kategori ' . $i . ' data inserted</li>';
                echo '</ul>';
            }
        }

    }

    private function warna($data = 10)
    {
        $config = array(
            'field' => 'w_nama',
            'title' => 'title',
            'table' => 'warna',
            'id' => 'w_id',
        );
        $this->load->library('slug', $config);


        for ($i = 1; $i <= $data; $i++) {
            $warna_nama = $this->randomString(10);
            $warna_array = array(
                'w_kode' => $this->warna->guid(),
                'w_nama' => $warna_nama,
                'w_url' => $this->slug->create_uri(array('title' => $warna_nama))
            );

            $warna = $this->warna->insert($warna_array);

            if ($warna) {
                echo '<ul>';
                echo '<li>Testing warna ' . $i . ' data inserted</li>';
                echo '</ul>';
            }
        }

    }

    private function ukuran($data = 10)
    {
        $config = array(
            'field' => 'u_nama',
            'title' => 'title',
            'table' => 'ukuran',
            'id' => 'u_id',
        );
        $this->load->library('slug', $config);


        for ($i = 1; $i <= $data; $i++) {
            $ukuran_nama = $this->randomString(10);
            $ukuran_array = array(
                'u_kode' => $this->ukuran->guid(),
                'u_nama' => $ukuran_nama,
                'u_url' => $this->slug->create_uri(array('title' => $ukuran_nama))
            );

            $ukuran = $this->ukuran->insert($ukuran_array);

            if ($ukuran) {
                echo '<ul>';
                echo '<li>Testing ukuran ' . $i . ' data inserted</li>';
                echo '</ul>';
            }
        }

    }

    private function seri($data = 10)
    {
        $config = array(
            'field' => 's_nama',
            'title' => 'title',
            'table' => 'seri',
            'id' => 's_id',
        );
        $this->load->library('slug', $config);


        for ($i = 1; $i <= $data; $i++) {
            $seri_nama = $this->randomString(15);
            $seri_array = array(
                's_kode' => $this->seri->guid(),
                's_nama' => $seri_nama,
                's_url' => $this->slug->create_uri(array('title' => $seri_nama))
            );

            $seri = $this->seri->insert($seri_array);

            if ($seri) {
                echo '<ul>';
                echo '<li>Testing seri ' . $i . ' data inserted</li>';
                echo '</ul>';
            }
        }

    }

    private function item($data = 10)
    {
        for ($v = 1; $v <= $data; $v++) {
            $config = array(
                'field' => 'i_nama',
                'title' => 'title',
                'table' => 'item',
                'id' => 'i_id',
            );
            $this->load->library('slug', $config);

            $item_kode = $this->item->guid();
            $item_nama = $this->randomString(10);
            $item_array = array(
                'i_kode' => $item_kode,
                'i_nama' => $item_nama,
                'i_hrg_vip' => mt_rand(9999, 999999),
                'i_hrg_reseller' => mt_rand(9999, 999999),
                'i_berat' => mt_rand(9, 999),
                'i_deskripsi' => $this->randomString(10),
                'i_url' => $this->slug->create_uri(array('title' => $item_nama))
            );

            // insert
            $item_table = $this->item->insert($item_array);
            $kategori_table = $this->kategori->get_all();
            $warna_table = $this->warna->get(1);
            $ukuran_table = $this->ukuran->get(1);
            $seri_table = $this->seri->get(1);


            for ($i = 1; $i <= 5; $i++) {
                $item_detil_kode = $this->item_detil->guid();
                $item_detil = $this->item_detil->insert(array(
                    'item_detil_kode' => $item_detil_kode,
                    'i_kode' => $item_kode,
                    'w_kode' => $warna_table->w_kode,
                    's_kode' => $seri_table->s_kode,
                    'u_kode' => $ukuran_table->u_kode,
                ));

                $item_qty = $this->item_qty->insert(array(
                    'iq_kode' => $this->item_qty->guid(),
                    'item_detil_kode' => $item_detil_kode,
                    'iq_qty' => mt_rand(9, 999)
                ));
            }

            if ($item_table) {
                $counter = 1;
                foreach ($kategori_table as $kategori) {
                    $item_kategori = $this->item_kategori->insert(array(
                        'ik_kode' => $this->item_kategori->guid(),
                        'i_kode' => $item_kode,
                        'k_kode' => $kategori->k_kode,
                    ));

                    if ($item_kategori) {
                        echo '<ul>';
                        echo '<li>Testing item_kategori ' . $counter . ' data inserted</li>';
                        echo '</ul>';
                    }
                    $counter += 1;
                }

            }

            if ($item_detil && $item_qty) {
                echo '<ul>';
                echo '<li>Testing item_detil && item_qty ' . $i . ' data inserted</li>';
                echo '</ul>';
            }
        }

    }

    public function bank($data = 10)
    {
        for ($v = 1; $v <= $data; $v++) {
            $bank_array = array(
                'bank_kode' => $this->bank->guid(),
                'bank_penerbit' => $this->randomString(3),
                'bank_nama' => $this->randomString(10),
                'bank_rek' => mt_rand(9999999999, 999999999999999),
                'bank_isaktif' => 1
            );

            $bank = $this->bank->insert($bank_array);
            if ($bank) {
                echo '<ul>';
                echo '<li>Testing bank ' . $v . ' data inserted</li>';
                echo '</ul>';
            }
        }
    }

    private function artikel($data = 10)
    {
        for ($v = 1; $v <= $data; $v++) {
            $config = array(
                'field' => 'artikel_judul',
                'title' => 'title',
                'table' => 'item',
                'id' => 'artikel_id',
            );
            $this->load->library('slug', $config);
            $artikel_judul = $this->randomString(10);

            $artikel_array = array(
                'artikel_kode' => $this->artikel->guid(),
                'artikel_judul' => $artikel_judul,
                'artikel_content' => $this->randomString(100),
                'artikel_url' => $this->slug->create_uri(array('title' => $artikel_judul)),
                'artikel_ispromo' => 1,
                'artikel_isblog' => 1,
                'artikel_isresi' => 0,
                'artikel_isnotifikasi' => 1,
                'artikel_isaktif' => 1
            );

            $artikel = $this->artikel->insert($artikel_array);

            if ($artikel) {
                echo '<ul>';
                echo '<li>Testing artikel ' . $v . ' data inserted</li>';
                echo '</ul>';
            }
        }
    }

    private function resi($data = 10)
    {
        for ($v = 1; $v <= $data; $v++) {
            $config = array(
                'field' => 'artikel_judul',
                'title' => 'title',
                'table' => 'item',
                'id' => 'artikel_id',
            );
            $this->load->library('slug', $config);

            $artikel_judul = $this->randomString(10);
            $artikel = $this->artikel->insert(array(
                'artikel_kode' => $this->artikel->guid(),
                'artikel_judul' => $artikel_judul,
                'artikel_content' => $this->randomString(100),
                'artikel_url' => $this->slug->create_uri(array('title' => $artikel_judul)),
                'artikel_isresi' => 1,
                'artikel_isaktif' => 1
            ));

            if ($artikel) {
                echo '<ul>';
                echo '<li>Testing resi ' . $v . ' data inserted</li>';
                echo '</ul>';
            }
        }
    }

    private function pengguna($data = 10)
    {
        for ($v = 1; $v <= $data; $v++) {
            $user_array = array(
                'pengguna_kode' => $this->pengguna->guid(),
                'pengguna_nama' => $this->randomString(10),
                'pengguna_username' => $this->randomString(5),
                'pengguna_password' => $this->randomString(10),
                'pengguna_email' => $this->randomString(5) . '@' . $this->randomString(5) . '.com',
                'pengguna_isaktif' => 1
            );

            $pengguna = $this->pengguna->insert($user_array);
            if ($pengguna) {
                echo '<ul>';
                echo '<li>Testing pengguna ' . $v . ' data inserted</li>';
                echo '</ul>';
            }
        }
    }

    private function cart($data = 10)
    {
        $item_detil = $this->item_detil->with_item()->limit($data)->get_all();
        $pengguna = $this->pengguna->get_all();
        foreach ($item_detil as $detil) {
            foreach ($pengguna as $user) {
                $cart_insert = $this->cart->insert(array(
                    'ca_kode' => $this->cart->guid(),
                    'ca_qty' => 1,
                    'ca_harga' => $detil->item->i_hrg_reseller,
                    'ca_tharga' => 1 * $detil->item->i_hrg_reseller,
                    'item_detil_kode' => $detil->item_detil_kode,
                    'pengguna_kode' => $user->pengguna_kode
                ));


                $item_qty_update = $this->item_qty->insert(array(
                    'iq_kode' => $this->item_qty->guid(),
                    'iq_qty' => -1,
                    'item_detil_kode' => $detil->item_detil_kode
                ));

                if ($cart_insert && $item_qty_update) {
                    echo '<ul>';
                    echo '<li>Testing cart && update QTY item ' . $detil->item->i_nama . ' for ' . $user->pengguna_nama . '</li>';
                    echo '</ul>';
                }
            }
        }
    }

    private function order($data = 10)
    {
        $item_detil = $this->item_detil->with_item()->limit($data)->get_all();
        $pengguna = $this->pengguna->get_all();


        foreach ($pengguna as $user) {
            $noid = date('ymd') . (int)$this->order->count_rows() + 1;
            $this->order->insert(array(
                'orders_noid' => $noid,
                'pengguna_kode' => $user->pengguna_kode
            ));

            foreach ($item_detil as $detil) {
                $order_detil = $this->order_detil->insert(array(
                    'orders_detil_qty' => 1,
                    'orders_detil_harga' => $detil->item->i_hrg_reseller,
                    'orders_detil_tharga' => 1 * $detil->item->i_hrg_reseller,
                    'orders_noid' => $noid,
                    'item_detil_kode' => $detil->item_detil_kode
                ));

                if ($order_detil) {
                    echo '<ul>';
                    echo '<li>Testing order && order_detil item ' . $detil->item->i_nama . ' for ' . $user->pengguna_nama . ' with order id ' . $noid . '</li>';
                    echo '</ul>';
                }
            }
        }

    }

}