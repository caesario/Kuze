<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pdf
{
    function load($param = [])
    {
        $param['tempDir'] = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf';
        return new \Mpdf\Mpdf($param);
    }
}