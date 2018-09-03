<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 24/02/2018
 * Time: 18.01
 */

class Provinsi_m extends MY_Model
{
    public function __construct()
    {
        $this->table = 'provinsi';
        $this->primary_key = 'provinsi_id';
        $this->protected = array();
        $this->timestamps = FALSE;
        $this->soft_deletes = FALSE;
        parent::__construct();
    }

    public function delete_all()
    {
        $this->db->empty_table($this->table);
    }
}