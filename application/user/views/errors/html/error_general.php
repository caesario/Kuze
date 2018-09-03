<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
if (!isset($CI)) {
    $CI = new CI_Controller();
}
$CI->load->helper('url');
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/font-awesome/css/all.css'); ?>" type="text/css">

    <link rel="stylesheet" href="<?= base_url('assets/vendor/font-awesome/css/font-awesome.min.css'); ?>"
          type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/css/eazy-style.css'); ?>">
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>

    <title><?php echo $heading; ?></title>
</head>
<body>

<div class="container">
    <div class="row align-items-center">
        <div class="col-2"></div>
        <div class="col text-center">
            <img class="img-fluid mt-5" src="<?= base_url('assets/img/error-404.png'); ?>" alt="404"><br>
            <a class="btn btn-success text-black" href="<?= site_url('/'); ?>">Back to Home</a>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="row align-items-center">
        <div class="col-2">
        </div>
        <div class="col" id="log" style="display: none;">
            <div class="text-center">
                <h1><?php echo $heading; ?></h1>
                <?php echo $message; ?>
            </div>

        </div>
        <div class="col-2">
        </div>
    </div>
</div>
<script>
    var log = $('#log').html();
    console.log(log);
</script>
</body>
</html>