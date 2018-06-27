<?php include "master/Header.php"; ?>
<body>
<?php include 'master/Menu.php'; ?>
<div class="page">
    <!-- navbar-->
    <header class="header">
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-holder d-flex align-items-center justify-content-between">
                    <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i
                                    class="icon-bars"> </i></a><a href="<?= base_url('adm.php/dashboard') ?>"
                                                                  class="navbar-brand">
                            <div class="brand-text d-none d-md-inline-block"><strong
                                        class="text-primary"><?= $brandname; ?></strong></div>
                        </a></div>
                    <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                        <li class="nav-item"><a href="<?= base_url('adm.php/auth/logout') ?>" class="nav-link logout">Logout<i
                                        class="fa fa-sign-out"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <br>
    <section>

        <?php if (isset($_SESSION['validation']) && $_SESSION['validation'] != ""): ?>
            <div class="col">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['validation']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['gagal']) && $_SESSION['gagal'] != ""): ?>
            <div class="col">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['gagal']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] != ""): ?>
            <div class="col">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['berhasil']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        <?php endif; ?>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h1>Resi</h1>


                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <p>
                                <a class="btn btn-primary" data-toggle="modal" href="#" onclick="tambah()"
                                   data-target="#crud" data-backdrop="static"
                                   data-keyboard="false"><i class="fa fa-plus mr-2"></i>Buat Data</a>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive">
                                <table id="tables" class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th scope="col">Judul</th>
                                        <th scope="col">Dibuat pada</th>
                                        <th scope="col">Diupdate pada</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($artikels != NULL): ?>
                                        <?php foreach ($artikels as $artikel): ?>
                                            <tr>
                                                <td><?= $artikel->artikel_judul; ?></td>
                                                <td><?= $artikel->created_at; ?></td>
                                                <td><?= $artikel->updated_at; ?></td>
                                                <td class="text-center">
                                                    <?php if ($artikel->artikel_kode != '0'): ?>
                                                        <a class="btn btn-sm btn-primary" data-toggle="modal"
                                                           title="Ubah <?= $title_page; ?>"
                                                           href="#"
                                                           onclick="edit($(this))" data-target="#crud"
                                                           data-backdrop="static"
                                                           data-keyboard="false"
                                                           data-id="<?= $artikel->artikel_kode; ?>"><i
                                                                    class="far fa-edit"></i> Ubah</a>
                                                        <a class="btn btn-sm btn-danger" data-toggle="modal"
                                                           title="Hapus <?= $title_page; ?>"
                                                           href="#"
                                                           onclick="hapus($(this))" data-target="#hapus"
                                                           data-id="<?= $artikel->artikel_kode; ?>"><i
                                                                    class="far fa-trash-alt"></i> Hapus</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script>
            // ------------------------------------------------------ //
            // Modal CRUD
            // ------------------------------------------------------ //

            function tambah() {
                modal = $('#crud');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('resi/tambah'); ?>");
            }

            function edit(data) {
                d = data;
                id = d.attr('data-id');
                modal = $('#crud');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('resi/ubah/'); ?>" + id);
            }

            function detil(data) {
                d = data;
                id = d.attr('data-id');
                modal = $('#crud');
                bodymodal = modal.find('div.modal-body');

                bodymodal.load("<?= site_url('resi/detil/'); ?>" + id);
            }

            function hapus(data) {
                d = data;
                id = d.attr('data-id');
                $('a#hapus').attr('href', "<?= site_url('resi/hapus/'); ?>" + id);
            }

            // ------------------------------------------------------ //
            // Data table
            // ------------------------------------------------------ //
            $('#tables').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian.json"
                }
            });


            $(document).ready(function () {
                $('[tooltip]').tooltip();
            });

            $('[id="konten"]').ellipsis();

            // ------------------------------------------------------ //
            // Remove after 5 second
            // ------------------------------------------------------ //

            $(document).ready(function () {
                setTimeout(function () {
                    if ($('[role="alert"]').length > 0) {
                        $('[role="alert"]').remove();
                    }
                }, 5000);
            });
        </script>
    </section>
    <footer class="main-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <p><?= $brandname; ?> &copy; 2018</p>
                </div>

            </div>
        </div>
    </footer>
</div>
<div class="modal fade" id="crud" tabindex="-1" role="dialog" aria-labelledby="crud" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="hapus" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">

            <div class="modal-body">
                <p>Apakah anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <a id="hapus" href="#" class="btn btn-sm btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>


</body>
</html>
