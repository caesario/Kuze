<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/select2/select2-bootstrap4.css'); ?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/font-awesome/css/all.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/font-awesome/css/font-awesome.min.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/css/fontastic.css'); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" href="<?= base_url('assets/css/grasp_mobile_progress_circle-1.0.0.min.css'); ?>">

    <link rel="stylesheet" href="<?= base_url('assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.default.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/croppie/croppie.css'); ?>">


    <style>
        .show > .btn-primary.dropdown-toggle:focus {
            box-shadow: none;
        }

        .btn-group-sm > .btn, .btn-sm {
            border-radius: 0;
        }

        .form-control {
            border-radius: 0;
        }
        .form-control:focus {
            background-color: #fff;
            border-color: #258141;
            box-shadow: none;
        }

        .custom-file-label {
            border-radius: 0;
        }

        .custom-file-input:focus ~ .custom-file-label {
            border-color: #258141;
            box-shadow: none;
    </style>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/datatable/css/dataTables.bootstrap4.min.css'); ?>">
    <link rel="shortcut icon" href="<?= base_url('upload/' . $icon); ?>">

    <!-- Javascript files-->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="<?= base_url('assets/vendor/popper.js/umd/popper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/datatable/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/datatable/js/dataTables.bootstrap4.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/grasp_mobile_progress_circle-1.0.0.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery.cookie/jquery.cookie.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-validation/jquery.validate.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/loadingoverlay/loadingoverlay.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/loadingoverlay/loadingoverlay_progress.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-ellipsis/jquery.ellipsis.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/wnumb/wNumb.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-fileupload/js/vendor/jquery.ui.widget.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-fileupload/js/jquery.fileupload.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/croppie/croppie.min.js'); ?>"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=omulajpwx33earwq4t3xfgo7zbqaoey3a7cd3zipl90xlzbu"></script>

    <!-- Main File-->
    <script src="<?= base_url('assets/js/front.js'); ?>"></script>
</head>