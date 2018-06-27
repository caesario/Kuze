<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 24/02/2018
 * Time: 18.01
 */

class Item_m extends MY_Model
{
    public function __construct()
    {
        $this->table = 'item';
        $this->primary_key = 'i_id';
        $this->protected = array('i_id', 'created_at', 'update_at');
        $this->timestamps = TRUE;
        $this->soft_deletes = FALSE;
        $this->has_many['item_detil'] = array(
            'foreign_model'=>'Item_detil_m',
            'foreign_table'=>'item_detil',
            'foreign_key'=>'i_kode',
            'local_key'=>'i_kode'
        );
        $this->has_many['item_kategori'] = array(
            'foreign_model'=>'Item_kategori_m',
            'foreign_table'=>'item_kategori',
            'foreign_key'=>'i_kode',
            'local_key'=>'i_kode'
        );
        $this->has_many['item_img'] = array(
            'foreign_model'=>'Item_img_m',
            'foreign_table'=>'item_img',
            'foreign_key'=>'i_kode',
            'local_key'=>'i_kode');
        parent::__construct();
    }

    public function guid()
    {
        if (function_exists('com_create_guid') === true)
            return trim(com_create_guid(), '{}');

        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function select_sum_qty()
    {

    }

    public function select_sum_qty_where($id)
    {
        $query = $this->db->query("SELECT i.i_kode, i.i_nama, i.i_hrg_reseller, i.i_hrg_vip, id.* , w.w_nama, u.u_nama, s.s_nama, SUM(iq.iq_qty) qty
                                    FROM item_detil id
                                    INNER JOIN item i ON id.i_kode = i.i_kode
                                    INNER JOIN warna w ON id.w_kode = w.w_kode
                                    INNER JOIN ukuran u ON id.u_kode = u.u_kode
                                    LEFT JOIN seri s ON id.s_kode = s.s_kode
                                    LEFT JOIN item_qty iq ON id.item_detil_kode = iq.item_detil_kode
                                    WHERE id.item_detil_kode = '$id'
                                    GROUP BY id.item_detil_kode;");

        return $query->result();
    }

    public function select_item_kategori_where_array($id)
    {
        $katitem = array();
        $query = $this->db->query("SELECT k.k_nama
                    FROM item_kategori ik
                    INNER JOIN item i ON ik.i_kode = i.i_kode
                    INNER JOIN kategori k ON ik.k_kode = k.k_kode
                    WHERE ik.i_kode = '$id';");

        foreach ($query->result() as $kat) {
            array_push($katitem, $kat->k_nama);
        }

        return $katitem;
    }

    public function select_item_kategori_where($id)
    {
        $query = $this->db->query("SELECT k.k_nama
                    FROM item_kategori ik
                    INNER JOIN item i ON ik.i_kode = i.i_kode
                    INNER JOIN kategori k ON ik.k_kode = k.k_kode
                    WHERE ik.i_kode = '$id';");


        return $query->result();
    }
}