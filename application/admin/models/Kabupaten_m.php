<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 24/02/2018
 * Time: 18.01
 */

class Kabupaten_m extends MY_Model
{
    public function __construct()
    {
        $this->table = 'kabupaten';
        $this->primary_key = 'kabupaten_id';
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