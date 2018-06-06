<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 24/02/2018
 * Time: 18.01
 */

class Ukuran_m extends MY_Model {
    public function __construct()
    {
        $this->table = 'ukuran';
        $this->primary_key = 'u_id';
        $this->protected = array('u_id','created_at','update_at');
        $this->timestamps = TRUE;
        $this->soft_deletes = TRUE;
        $this->has_many['item_detil'] = array(
            'foreign_model'=>'Item_detil_m',
            'foreign_table'=>'item_detil',
            'foreign_key'=>'u_kode',
            'local_key'=>'u_kode');
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
        $query = $this->db->query("SELECT u.u_nama nama
                                    FROM item_ukuran iu
                                    INNER JOIN item i ON iu.i_kode = i.i_kode
                                    INNER JOIN ukuran u ON iu.u_kode = u.u_kode
                                    WHERE i.i_kode = '$item';");
        return $query->result();
    }
}