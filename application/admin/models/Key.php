<?php
/**
 * Created by PhpStorm.
 * User: irfandihati
 * Date: 24/02/2018
 * Time: 18.01
 */

class Key extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function set_customers()
    {
        return 'CUS-' . date('Ymd') . '-' . date('His');
    }

    public function set_users()
    {
        return 'USR-' . date('Ymd') . '-' . date('His');
    }

}