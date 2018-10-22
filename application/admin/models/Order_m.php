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
        $this->primary_key = 'orders_noid';
        $this->protected = array('created_at', 'update_at');
        $this->timestamps = TRUE;
        $this->soft_deletes = FALSE;
        $this->has_many['order_detil'] = array(
            'foreign_model'=>'order_detil_m',
            'foreign_table'=>'order_detil',
            'foreign_key'=>'orders_noid',
            'local_key'=>'orders_noid'
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
        $query = $this->db->query("SELECT orders.*, pengguna.pengguna_nama, SUM(orders_detil.orders_detil_tharga) total
                                    FROM orders
                                    INNER JOIN pengguna
                                    ON orders.pengguna_kode = pengguna.pengguna_kode
                                    LEFT JOIN orders_detil
                                    ON orders.orders_noid = orders_detil.orders_noid
                                    GROUP BY orders.orders_noid");

        return $query->result();
    }

    public function select_orders_users($id)
    {
        $query = $this->db->query("SELECT orders.orders_noid, orders.created_at, orders.orders_status, orders.orders_deskripsi, pengguna.pengguna_nama, SUM(orders_detil.orders_detil_tharga) total
                                    FROM orders
                                    INNER JOIN pengguna
                                    ON orders.pengguna_kode = pengguna.pengguna_kode
                                    LEFT JOIN orders_detil
                                    ON orders.orders_noid = orders_detil.orders_noid
                                    WHERE pengguna.pengguna_kode = '$id'
                                    GROUP BY orders.orders_noid;");

        return $query->result();
    }

    public function select_orders_where($status)
    {
        $query = $this->db->query("SELECT orders.orders_noid, orders.orders_status, pengguna.pengguna_nama, SUM(orders_detil.orders_detil_tharga) total
                                    FROM orders
                                    INNER JOIN pengguna
                                    ON orders.pengguna_kode = pengguna.pengguna_kode
                                    LEFT JOIN orders_detil
                                    ON orders.orders_noid = orders_detil.orders_noid
                                    WHERE orders.orders_status = $status
                                    GROUP BY orders.orders_noid;");

        return $query->result();
    }

    public function select_orders_where_id($id)
    {
        $query = $this->db->query("SELECT orders.orders_noid, orders.orders_status, pengguna.pengguna_nama, SUM(orders_detil.orders_detil_tharga) total
                                    FROM orders
                                    INNER JOIN pengguna
                                    ON orders.pengguna_kode = pengguna.pengguna_kode
                                    LEFT JOIN orders_detil
                                    ON orders.orders_noid = orders_detil.orders_noid
                                    WHERE orders.orders_noid = $id
                                    GROUP BY orders.orders_noid;");

        return $query->result();
    }

    public function select_orders_bukti($status)
    {
        $query = $this->db->query("SELECT orders_bukti.*, orders.*
                                    FROM orders_bukti
                                    LEFT JOIN orders
                                    ON orders_bukti.orders_noid = orders.orders_noid
                                    WHERE orders.orders_status = $status;");

        return $query->result();
    }

    public function select_invoice($status)
    {
        $query = $this->db->query("SELECT orders.orders_noid, orders.orders_status, orders.created_at, orders_resi.orders_resi_no, pengguna.pengguna_nama, SUM(orders_detil.orders_detil_tharga) total
                                    FROM orders
                                    INNER JOIN pengguna
                                    ON orders.pengguna_kode = pengguna.pengguna_kode
                                    LEFT JOIN orders_resi
                                    ON orders.orders_noid = orders_resi.orders_noid
                                    LEFT JOIN orders_detil
                                    ON orders.orders_noid = orders_detil.orders_noid
                                    WHERE orders.orders_status = $status
                                    GROUP BY orders.orders_noid;");

        return $query->result();
    }

    public function select_invoice_users($id, $status)
    {
        $query = $this->db->query("SELECT orders.orders_noid, orders.orders_status, orders.created_at, orders_resi.orders_resi_no, pengguna.pengguna_nama, SUM(orders_detil.orders_detil_tharga) total
                                    FROM orders
                                    INNER JOIN pengguna
                                    ON orders.pengguna_kode = pengguna.pengguna_kode
                                    LEFT JOIN orders_resi
                                    ON orders.orders_noid = orders_resi.orders_noid
                                    LEFT JOIN orders_detil
                                    ON orders.orders_noid = orders_detil.orders_noid
                                    WHERE orders.orders_status = $status 
                                    AND
                                    pengguna.pengguna_kode = '$id'
                                    GROUP BY orders.orders_noid;");

        return $query->result();
    }
}