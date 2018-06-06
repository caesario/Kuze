<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 24/02/2018
 * Time: 18.01
 */

class Order_ongkir_m extends MY_Model
{
    public function __construct()
    {
        $this->table = 'orders_ongkir';
        $this->primary_key = 'oo_id';
        $this->protected = array('oo_id', 'created_at', 'update_at');
        $this->timestamps = TRUE;
        $this->soft_deletes = TRUE;
        $this->has_one['order'] = array(
            'foreign_model' => 'Order_m',
            'foreign_table' => 'orders',
            'foreign_key' => 'o_kode',
            'local_key' => 'o_kode');
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
}