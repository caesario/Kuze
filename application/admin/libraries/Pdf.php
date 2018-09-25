<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pdf
{
    function load($param = [])
    {
        return new \Mpdf\Mpdf($param);
    }
}