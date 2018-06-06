<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 24/02/2018
 * Time: 18.01
 */

class Kategori_m extends MY_Model {
    public function __construct()
    {
        $this->table = 'kategori';
        $this->primary_key = 'k_id';
        $this->protected = array('k_id','created_at','update_at');
        $this->timestamps = TRUE;
        $this->has_many['item_kategori'] = array(
            'foreign_model'=>'Item_kategori_m',
            'foreign_table'=>'item_kategori',
            'foreign_key'=>'k_kode',
            'local_key'=>'k_kode');
        $this->soft_deletes = TRUE;
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

    public function many_to_many_where($item) {
        $query = $this->db->query("SELECT k.k_nama nama
                                    FROM item_kategori ik
                                    INNER JOIN item i ON ik.i_kode = i.i_kode
                                    INNER JOIN kategori k ON ik.k_kode = k.k_kode
                                    WHERE i.i_kode = '$item';");
        return $query->result();
    }
}