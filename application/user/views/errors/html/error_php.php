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

    <title>A PHP Error was encountered</title>
</head>
<body>

<div class="container">
    <div class="row align-items-center">
        <div class="col-2"></div>
        <div class="col text-center">
            <img class="img-fluid" src="<?= base_url('assets/img/error-404.png'); ?>" alt="404">
            <a class="btn btn-primary r-btn-pink" href="<?= site_url('/'); ?>">Kembali ke halaman utama</a>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="row align-items-center">
        <div class="col-2">
        </div>
        <div class="col" id="log" style="display: none;">
            <h4>A PHP Error was encountered</h4>

            <p>Severity: <?php echo $severity; ?></p>
            <p>Message: <?php echo $message; ?></p>
            <p>Filename: <?php echo $filepath; ?></p>
            <p>Line Number: <?php echo $line; ?></p>

            <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

                <p>Backtrace:</p>
                <?php foreach (debug_backtrace() as $error): ?>

                    <?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

                        <p style="margin-left:10px">
                            File: <?php echo $error['file'] ?><br/>
                            Line: <?php echo $error['line'] ?><br/>
                            Function: <?php echo $error['function'] ?>
                        </p>

                    <?php endif ?>

                <?php endforeach ?>

            <?php endif ?>

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