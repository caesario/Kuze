<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 24/02/2018
 * Time: 18.01
 */

class Order_detil_m extends MY_Model
{
    public function __construct()
    {
        $this->table = 'orders_detil';
        $this->primary_key = 'od_id';
        $this->protected = array('od_id', 'created_at', 'update_at');
        $this->timestamps = TRUE;
        $this->soft_deletes = FALSE;
        $this->has_one['order'] = array(
            'foreign_model'=>'Order_m',
            'foreign_table'=>'orders',
            'foreign_key'=>'orders_noid',
            'local_key'=>'orders_noid');
        $this->has_one['item_detil'] = array(
            'foreign_model'=>'Item_detil_m',
            'foreign_table'=>'item_detil',
            'foreign_key'=>'item_detil_kode',
            'local_key'=>'item_detil_kode');
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