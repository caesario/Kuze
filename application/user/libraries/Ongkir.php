<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Ongkir/Endpoints.php';

class Ongkir extends Endpoints
{
    private $api_key;
    private $account_type;
    private $_ci;

    public function __construct()
    {
        // Pastikan bahwa PHP mendukung cURL
        if (!function_exists('curl_init')) {
            log_message('error', 'cURL Class - PHP was not built with cURL enabled. Rebuild PHP with --with-curl to use cURL.');
        }
        $this->_ci = &get_instance();
        $this->_ci->load->config('ongkir', TRUE);
        // Pastikan Anda sudah memasukkan API Key di application/config/rajaongkir.php
        if ($this->_ci->config->item('api_key', 'ongkir') == "") {
            log_message("error", "Harap masukkan API KEY Anda di config.");
        } else {
            $this->api_key = $this->_ci->config->item('api_key', 'ongkir');
            $this->account_type = $this->_ci->config->item('account_type', 'ongkir');
        }
        parent::__construct($this->api_key, $this->account_type);
    }
}