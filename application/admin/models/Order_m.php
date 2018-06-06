<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 24/02/2018
 * Time: 18.01
 */

class Order_m extends MY_Model
{
    public function __construct()
    {
        $this->table = 'orders';
        $this->primary_key = 'o_id';
        $this->protected = array('o_id', 'created_at', 'update_at');
        $this->timestamps = TRUE;
        $this->soft_deletes = TRUE;
        $this->has_many['order_detil'] = array(
            'foreign_model'=>'order_detil_m',
            'foreign_table'=>'order_detil',
            'foreign_key'=>'o_kode',
            'local_key'=>'o_kode'
        );
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

    public function select_orders()
    {
        $query = $this->db->query("SELECT orders.o_kode, orders.created_at, orders.o_noorder, orders.o_status, pengguna.p_nama, SUM(orders_detil.od_tharga) total
                                    FROM orders
                                    INNER JOIN pengguna
                                    ON orders.p_kode = pengguna.p_kode
                                    LEFT JOIN orders_detil
                                    ON orders.o_kode = orders_detil.o_kode
                                    GROUP BY orders.o_noorder;");

        return $query->result();
    }

    public function select_orders_where($status)
    {
        $query = $this->db->query("SELECT orders.o_kode, orders.o_noorder, orders.o_status, pengguna.p_nama, SUM(orders_detil.od_tharga) total
                                    FROM orders
                                    INNER JOIN pengguna
                                    ON orders.p_kode = pengguna.p_kode
                                    LEFT JOIN orders_detil
                                    ON orders.o_kode = orders_detil.o_kode
                                    WHERE orders.o_status = $status
                                    GROUP BY orders.o_noorder;");

        return $query->result();
    }

    public function select_orders_bukti($status)
    {
        $query = $this->db->query("SELECT orders_bukti.*, orders.o_noorder, orders.o_status
                                    FROM orders_bukti
                                    LEFT JOIN orders
                                    ON orders_bukti.o_kode = orders.o_kode
                                    WHERE orders.o_status = $status;");

        return $query->result();
    }

    public function select_invoice()
    {
        $query = $this->db->query("SELECT orders.o_noorder, orders.o_status, pengguna.p_nama, SUM(orders_detil.od_tharga) total
                                    FROM orders
                                    INNER JOIN pengguna
                                    ON orders.p_kode = pengguna.p_kode
                                    LEFT JOIN orders_detil
                                    ON orders.o_kode = orders_detil.o_kode
                                    WHERE orders.o_status = '6'
                                    GROUP BY orders.o_noorder;");

        return $query->result();
    }
}