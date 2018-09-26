<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.css'); ?>">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= site_url('assets/vendor/select2/select2-bootstrap4.min.css'); ?>" />
    <link rel="stylesheet" href="<?= site_url('assets/vendor/datatable/css/dataTables.bootstrap4.min.css'); ?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fotorama/fotorama.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/eazy-style.css') ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <style>
        .spinner {
            margin: 100px auto;
            width: 50px;
            height: 40px;
            text-align: center;
            font-size: 10px;
        }

        .spinner > div {
            background-color: #333;
            height: 100%;
            width: 6px;
            display: inline-block;

            -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
            animation: sk-stretchdelay 1.2s infinite ease-in-out;
        }

        .spinner .rect2 {
            -webkit-animation-delay: -1.1s;
            animation-delay: -1.1s;
        }

        .spinner .rect3 {
            -webkit-animation-delay: -1.0s;
            animation-delay: -1.0s;
        }

        .spinner .rect4 {
            -webkit-animation-delay: -0.9s;
            animation-delay: -0.9s;
        }

        .spinner .rect5 {
            -webkit-animation-delay: -0.8s;
            animation-delay: -0.8s;
        }

        @-webkit-keyframes sk-stretchdelay {
            0%, 40%, 100% {
                -webkit-transform: scaleY(0.4)
            }
            20% {
                -webkit-transform: scaleY(1.0)
            }
        }

        @keyframes sk-stretchdelay {
            0%, 40%, 100% {
                transform: scaleY(0.4);
                -webkit-transform: scaleY(0.4);
            }
            20% {
                transform: scaleY(1.0);
                -webkit-transform: scaleY(1.0);
            }
        }
    </style>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="<?= base_url('assets/vendor/popper.js/umd/popper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/fotorama/fotorama.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-ellipsis/jquery.ellipsis.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-emoji-rating/jquery.emojiRatings.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/wnumb/wNumb.js'); ?>"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/vendor/fotorama/fotorama.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-lazy/jquery.lazy.min.js'); ?>"></script>
    <script>
        function img_hover(data) {
            var img = data,
                id = img.attr('id'),
                hasil = "";
            $.getJSON("/API/get_last_img/" + id, function (data) {
                img.fadeOut(100, function () {
                    hasil = "data:" + data["type"] + ";base64," + data["img"];
                    img.attr("src", hasil);
                    img.fadeIn(100);
                });
            });

        }

        function img_off(data) {
            var img = data,
                id = img.attr('id'),
                hasil = "";

            $.getJSON("/API/get_default_img/" + id, function (data) {
                img.fadeOut(100, function () {
                    hasil = "data:" + data["type"] + ";base64," + data["img"];
                    img.attr("src", hasil);
                    img.fadeIn(100);
                });
            });
        }
    </script>


    <link rel="shortcut icon" href="<?= base_url('assets/img/kuzelogo.jpeg'); ?>">

    <title><?= $brandname; ?></title>
</head>
<body>