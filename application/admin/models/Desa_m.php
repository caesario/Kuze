<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 24/02/2018
 * Time: 18.01
 */

class Desa_m extends MY_Model
{
    public function __construct()
    {
        $this->table = 'desa';
        $this->primary_key = 'desa_id';
        $this->protected = array('desa_id');
        $this->timestamps = FALSE;
        $this->soft_deletes = FALSE;
        parent::__construct();
    }
}