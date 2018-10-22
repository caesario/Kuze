<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 12/03/2018
 * Time: 23.23
 */

class Order extends MY_Controller
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
        $this->data->title = $this->data->brandname . ' | Order';
        $this->data->title_page = 'Order';
        $this->data->total_order = $this->order->count_rows();
        $this->data->orders = $this->order->select_orders();
        $this->load->view('Order', $this->data);
    }

    public function konfirmasi()
    {
        $this->data->title = $this->data->brandname . ' | Kofirmasi Order';
        $this->data->title_page = 'Pembayaran';
        $this->data->total_order = $this->order->count_rows();
        $this->data->orders = $this->order->select_orders_bukti(3);
        $this->load->view('Order_k', $this->data);
    }

    public function proses_konfirmasi($id)
    {
        $order = $this->order->where_orders_noid($id)->update(
            array(
                'orders_status' => 4
            )
        );

        if ($order) {
            $this->data->berhasil = 'Konfirmasi Order berhasil';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('order/proses/' . $id);
        } else {
            $this->data->gagal = 'Konfirmasi Order gagal';
            $this->session->set_flashdata('gagal', $this->data->gagal);

            redirect('order/proses' . $id);
        }
    }

    public function get_konfirmasi($id)
    {
        $order = $this->order_bukti->where('orders_noid', $id)->get();

        if ($order) {
            $this->data->order = $order;
            $this->load->view('Order_g', $this->data);
        }
    }

    public function invoice()
    {
        $this->data->title = $this->data->brandname . ' | Invoice';
        $this->data->title_page = 'Invoice';
        $this->data->total_order = $this->order->count_rows();
        $this->data->orders = $this->order->select_invoice(6);
        $this->load->view('Order_i', $this->data);
    }

    public function tambah()
    {
        $this->data->title = $this->data->brandname . ' | Order > Tambah';
        $this->data->submit = 'Simpan';
        $this->data->kode = $this->order->guid();
        $this->load->view('CRUD_Order', $this->data);
    }

    public function ubah($id)
    {
        $this->data->title = $this->data->brandname . ' | Order > Ubah';
        $this->data->submit = 'Ubah';
        $this->data->kode = $id;
        $this->data->orders = $this->order->where('u_kode', $id)->get();

        $this->load->view('CRUD_Order', $this->data);
    }

    public function simpan()
    {
        // create object
        // get guid form post
        $id = $this->input->post('id');

        // get user from database where guid
        $order = $this->order->where_u_kode($id)->get();

        if ($order) {
            $order = $this->order->where_u_kode($id)->update(array(
                'u_nama' => $this->input->post('nama'),
                'updated_by' => $_SESSION['username'],
            ));
            if ($order) {
                $this->data->berhasil = 'Data Order berhasil diperbarui.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('order');
            } else {
                $this->data->gagal = 'Data Order gagal diperbarui.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('order');
            }
        } else {
            $order = $this->order->insert(array(
                'u_kode' => $this->input->post('id'),
                'u_nama' => $this->input->post('nama'),
//                'created_by'      => $_SESSION['username'],
            ));
            if ($order) {
                $this->data->berhasil = 'Data Order berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('order');
            } else {
                $this->data->gagal = 'Data Order gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('order');
            }
        }
    }

    public function hapus($id)
    {
        $order = $this->order->where('u_kode', $id)->delete();
        if ($order) {
            $this->data->berhasil = 'Data Order berhasil dihapus';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('order');
        } else {
            $this->data->gagal = 'Data Order gagal dihapus';
            $this->session->set_flashdata('berhasil', $this->data->gagal);

            redirect('order');
        }
    }

    public function proses($id)
    {
        $order = $this->order->update(
            array(
                'orders_noid' => $id,
                'orders_status' => 5
            ), 'orders_noid'
        );

        if ($order) {
            $this->data->berhasil = 'Order telah/sedang berhasil diproses';
            $this->session->set_flashdata('berhasil', $this->data->berhasil);

            redirect('order');
        } else {
            $this->data->gagal = 'Order telah/sedang gagal diproses';
            $this->session->set_flashdata('gagal', $this->data->gagal);

            redirect('order');
        }
    }

    public function batal($id)
    {
        $text = $this->input->post('alasan');

        $order = $this->order->update(
            array(
                'orders_noid' => $id,
                'orders_status' => 7,
                'orders_deskripsi'   => $text

            ), 'orders_noid'
        );

        $order_detil = $this->order_detil->where('orders_noid', $id)->get();

        if ($order_detil && $order) {
            $item_qty_update = $this->item_qty->insert(array(
                'iq_kode' => $this->item_qty->guid(),
                'iq_qty' => $order_detil->orders_detil_qty,
                'item_detil_kode' => $order_detil->item_detil_kode
            ));
            if ($item_qty_update) {
                $this->data->berhasil = 'Order telah berhasil dibatalkan';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);

                redirect('order');
            } else {
                $this->data->gagal = 'Order telah gagal dibatalkan';
                $this->session->set_flashdata('gagal', $this->data->gagal);

                redirect('order');
            }
        }


    }

    public function resi($id)
    {
        $this->data->orders_noid = $id;
        $this->load->view('CRUD_Pengiriman', $this->data);
    }

    public function resi_pengiriman()
    {
        $data_order = array(
            'orders_noid' => $this->input->post('orders_noid'),
            'orders_status' => 6
        );

        $data_resi = array(
            'orders_noid' => $this->input->post('orders_noid'),
            'orders_resi_no' => $this->input->post('resi')
        );

        if ($this->order->update($data_order, 'orders_noid')) {
            if ($this->order_resi->update($data_resi, 'orders_noid')) {
                $this->data->berhasil = 'Resi telah berhasil dibuat.';
                $this->session->set_flashdata('berhasil', $this->data->berhasil);
            } else {
                $this->data->gagal = 'Resi telah gagal dibuat.';
                $this->session->set_flashdata('gagal', $this->data->gagal);
            }
        } else {
            $this->data->gagal = 'Gagal mengubah status order.';
            $this->session->set_flashdata('gagal', $this->data->gagal);
        }

        redirect('Order');

    }

    public function repair_order()
    {
        echo '<pre>';
        foreach ($this->order->with_order_detil()->get_all() as $o) {
            if (!isset($o->order_detil)) {
                echo 'data order dengan nomor order ' . $o->orders_noid . ' tidak valid.<br>';
                echo 'hapus ' . $o->orders_noid . ' ...';

                $this->order_ongkir->where('orders_noid', $o->orders_noid)->delete();
                echo 'ongkir order dengan nomor order ' . $o->orders_noid . ' telah dihapus.<br>';
                $this->order_bukti->where('orders_noid', $o->orders_noid)->delete();
                echo 'bukti order dengan nomor order ' . $o->orders_noid . ' telah dihapus.<br>';
                $this->order_payment->where('orders_noid', $o->orders_noid)->delete();
                echo 'payment order dengan nomor order ' . $o->orders_noid . ' telah dihapus.<br>';
                $this->order_pengiriman->where('orders_noid', $o->orders_noid)->delete();
                echo 'pengiriman order dengan nomor order ' . $o->orders_noid . ' telah dihapus.<br>';
                $this->order_resi->where('orders_noid', $o->orders_noid)->delete();
                echo 'resi order dengan nomor order ' . $o->orders_noid . ' telah dihapus.<br>';
                $this->order->where('orders_noid', $o->orders_noid)->delete();
                echo 'data order dengan nomor order ' . $o->orders_noid . ' telah dihapus.<br>';
            } else {
                echo 'data order dengan nomor order ' . $o->orders_noid . ' valid.<br>';
            }
        }
        echo '</pre>';
    }

    public function set_uniq()
    {
        echo '<pre>';
        foreach ($this->order->get_all() as $o) {
            $uniq = mt_rand(100, 399);
            $this->order->where('orders_noid', $o->orders_noid)->update(array('orders_uniq' => $uniq));
            echo 'berhasil menambah kode unik ' . $uniq . ' dengan nomor order ' . $o->orders_noid . '<br>';
        }
        echo '</pre>';
    }

    public function detil($id)
    {
        $order = $this->order->where('orders_noid', $id)->get();
        $order_detils = function () use ($id) {
            $data_array = array();
            $index = 0;
            foreach ($this->order_detil->where('orders_noid', $id)->get_all() as $o) {
                $item_detil_kode = $o->item_detil_kode;
                $data_array[$index]['orders_item_nama'] = $this->item_detil->with_item()->where('item_detil_kode', $item_detil_kode)->get()->item->i_nama;
                $data_array[$index]['orders_detil_qty'] = $o->orders_detil_qty;
                $data_array[$index]['orders_detil_harga'] = $o->orders_detil_harga;
                $data_array[$index]['orders_detil_tharga'] = $o->orders_detil_tharga;
                $index += 1;
            }

            return (object)$data_array;

        };
        $duedate = function () use ($id) {
            $order = $this->order->where('orders_noid', $id)->get();
            $duedate = strtotime($order->created_at);
            $duedate += 21600;
            $duedate = date('Y-m-d H:i:s', $duedate);
            return $duedate;
        };

        $orders_total = function () use ($id) {
            $hasil = 0;
            $order = $this->order_detil->where('orders_noid', $id)->get_all();
            foreach ($order as $o) {
                $hasil += $o->orders_detil_tharga;
            }
            return (int)$hasil;
        };
        $pengiriman = function () use ($id) {
            $alamat = new stdClass();
            $order_pengiriman = $this->order_pengiriman->where('orders_noid', $id)->get();

            if ($order_pengiriman) {
                $alamat->provinsi = $this->provinsi
                    ->where('provinsi_id', $order_pengiriman->orders_pengiriman_provinsi)
                    ->get()->provinsi_nama;
                $alamat->kabupaten = $this->kabupaten
                    ->where('kabupaten_id', $order_pengiriman->orders_pengiriman_kabupaten)
                    ->get()->kabupaten_nama;
                $alamat->kecamatan = $this->kecamatan
                    ->where('kecamatan_id', $order_pengiriman->orders_pengiriman_kecamatan)
                    ->get()->kecamatan_nama;
                $hasil = $order_pengiriman->orders_pengiriman_deskripsi . ', <br>' . $alamat->kecamatan . ', ' . $alamat->kabupaten . '<br>' .
                    $alamat->provinsi . ', ' . $order_pengiriman->orders_pengiriman_kodepos;
            } else {
                $hasil = '';
            }
            return $hasil;

        };

        $pengiriman_kontak = function () use ($id) {
            return $order_pengiriman = $this->order_pengiriman->where('orders_noid', $id)->get();
        };

        $jasa = function () use ($id) {
            $ongkir = $this->order_ongkir->where('orders_noid', $id)->get();

            if ($ongkir) {
                return $ongkir->orders_ongkir_nama . ' - ' . $ongkir->orders_ongkir_deskripsi . ' (' . $ongkir->orders_ongkir_estimasi . ' hari)';

            } else {
                return 'Belum menentukan metode pengiriman';
            }

        };

        $metode_pembayaran = function () use ($id) {
            $orders_noid = $this->order
                ->where('orders_noid', $id)
                ->get()->orders_noid;
            $pembayaran = $this->order_payment->with_bank()->where('orders_noid', $orders_noid)->get();

            if ($pembayaran) {
                $hasil = $pembayaran->bank->bank_penerbit . ' - (A/N: ' . $pembayaran->bank->bank_nama . ') (Nomor Rek: ' . $pembayaran->bank->bank_rek . ')';

            } else {
                $hasil = 'Belum menentukan metode pembayaran';
            }

            return $hasil;
        };

        $biaya_subtotal = function () use ($id) {
            $hasil = 0;
            $orders_noid = $this->order
                ->where('orders_noid', $id)
                ->get()->orders_noid;
            foreach ($this->order_detil->where('orders_noid', $orders_noid)->get_all() as $od) {
                $hasil += (int)$od->orders_detil_tharga;
            }

            return (int)$hasil;
        };

        $biaya_pengiriman = function () use ($id) {
            $orders_noid = $this->order
                ->where('orders_noid', $id)
                ->get()->orders_noid;
            $ongkir = $this->order_ongkir->where('orders_noid', $orders_noid)->get();

            if ($ongkir) {
                return (int)$ongkir->orders_ongkir_biaya;
            } else {
                return 0;
            }


        };

        $diskon_harga = function () use ($id) {
            $promo_kode = $this->order
                ->where('orders_noid', $id)
                ->get()->promo_kode;
            $promo = $this->promo->where('promo_kode', $promo_kode)->get();


            $harga = $this->order
                ->where('orders_noid', $id)
                ->get()->orders_hrg;

            if ($promo) {
                $promo_rate = $promo->promo_rate;
                $promo_nominal = $promo->promo_nominal;
            } else {
                $promo_rate = 0;
                $promo_nominal = 0;
            }


            if ($promo_rate != 0) {
                $potongan = $harga * ($promo_rate / 100);

            } elseif ($promo_nominal != 0) {
                $potongan = $promo_nominal;
            } else {
                $potongan = 0;
            }

            return (int)$potongan;

        };


        $this->data->orders_noid = $id;
        $this->data->createdate = $order->created_at;
        $this->data->status = $order->orders_status;
        $this->data->duedate = $duedate();
        $this->data->order_detils = $order_detils();
        $this->data->pengiriman = $pengiriman();
        $this->data->pengiriman_kontak = $pengiriman_kontak();
        $this->data->jasa = $jasa();
        $this->data->metode_pembayaran = $metode_pembayaran();
        $this->data->orders_total = $orders_total();
        $this->data->biaya_subtotal = $biaya_subtotal();
        $this->data->diskon_harga = $diskon_harga();
        $this->data->biaya_pengiriman = $biaya_pengiriman();
        $this->data->grand_total = $biaya_subtotal() - $diskon_harga() + $biaya_pengiriman();

        $this->load->view('Detil_order', $this->data);
    }

}