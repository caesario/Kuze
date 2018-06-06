<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $brandname; ?> | Login</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/fontastic.css'); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" href="<?= base_url('assets/css/grasp_mobile_progress_circle-1.0.0.min.css'); ?>">
    <link rel="stylesheet"
          href="<?= base_url('assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.default.css" id="theme-stylesheet'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.pink.css'); ?>">

    <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.ico'); ?>">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script>
        var base_url = '<?= base_url(); ?>';
        var hashing = '<?= $this->security->get_csrf_hash(); ?>';
    </script>
</head>
<body>
<div class="page login-page">
    <div class="container">
        <div class="form-outer text-center align-items-center">
            <div class="form-inner">
                <div class="logo text-uppercase"><strong class="text-primary">Login</strong>
                </div>
                <p>Administrator</p>
                <form id="loginForm" name="loginForm" method="post" action="<?= site_url('auth/login'); ?>">
                    <input type="hidden" name="token_fg" value="<?= $this->security->get_csrf_hash(); ?>">
                    <div class="form-group-material">
                        <input id="login-username" type="text" name="username" class="input-material"
                               required>
                        <label for="login-username" class="label-material">Username</label>
                        <div class="text-left invalid-feedback">
                            <?= form_error('username'); ?>
                        </div>
                    </div>
                    <div class="form-group-material">
                        <input id="login-password" type="password" name="password" class="input-material"
                               required>
                        <label for="login-password" class="label-material">Password</label>
                        <div class="text-left invalid-feedback">
                            <?= form_error('password'); ?>
                        </div>

                    </div>
                    <button id="login" class="btn btn-block btn-primary">Login</button>
                </form>
                <?php if (isset($log) && $log != ""): ?>
                <p class="text-danger"><?= $log; ?></p>
                <?php endif; ?>
            </div>
            <div class="copyrights text-center">
                <p><a href="https://fashiongrosir-ind.com" class="external"><?= $brandname; ?></a></p>
            </div>
        </div>
    </div>
</div>
<!-- Javascript files-->
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/popper.js/umd/popper.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/grasp_mobile_progress_circle-1.0.0.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/jquery.cookie/jquery.cookie.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/chart.js/Chart.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/jquery-validation/jquery.validate.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
<!-- Main File-->
<script src="<?= base_url('assets/js/front.js'); ?>"></script>
</body>
</html>