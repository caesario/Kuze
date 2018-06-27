<?php if (isset($_SESSION['validation']) && $_SESSION['validation'] != ""): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['validation']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['gagal']) && $_SESSION['gagal'] != ""): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['gagal']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] != ""): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['berhasil']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<div class="table-responsive">
    <table id="tables" class="table">
        <thead>
        <tr>
            <th scope="col">Gambar</th>
            <th scope="col" class="text-center">Default</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php if ($item_imgs != NULL): ?>
            <?php foreach ($item_imgs as $img): ?>
                <tr>
                    <td class="align-middle">
                        <div class="fotorama"
                             data-nav="false"
                             data-arrows="false"
                             data-click="true"
                             data-swipe="true"
                             data-allowfullscreen="true"
                             data-width="220"
                             data-height="150">
                            <img src="<?= base_url('upload/' . $img->ii_nama); ?>"
                                 width="220" height="150">
                        </div>
                    </td>
                    <td class="align-middle text-center"><?= $img->ii_default == 0 ? '<i class="fas fa-times"></i>' : '<i class="fas fa-check"></i>'; ?></td>
                    <td class="align-middle">
                        <a class="btn btn-sm btn-primary"
                           href="<?= site_url('item_img/set_default/' . $img->i_kode . '/' . $img->ii_kode); ?>"
                           onclick="utama($(this))" data-id="<?= $img->ii_kode; ?>">
                            Set Default
                        </a>
                        <a class="btn btn-sm btn-danger" href="<?= site_url('item_img/hapus/' . $img->ii_kode); ?>"
                           data-id="<?= $img->ii_kode; ?>">
                            Hapus
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<hr>
<button class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
<script>
    // ------------------------------------------------------ //
    // Modal CRUD
    // ------------------------------------------------------ //

    function tambah() {
        modal = $('#crud');
        bodymodal = modal.find('div.modal-body');

        bodymodal.load("<?= site_url('item/tambah'); ?>");
    }

    function edit(data) {
        d = data;
        id = d.attr('data-id');
        modal = $('#crud');
        bodymodal = modal.find('div.modal-body');

        bodymodal.load("<?= site_url('item/ubah/'); ?>" + id);
    }

    function tambah_qty(data) {
        d = data;
        id = d.attr('data-id');
        modal = $('#crud');
        bodymodal = modal.find('div.modal-body');

        bodymodal.load("<?= site_url('item/tambah_qty/'); ?>" + id);
    }

    function detil(data) {
        d = data;
        id = d.attr('data-id');
        modal = $('#crud');
        bodymodal = modal.find('div.modal-body');

        bodymodal.load("<?= site_url('item/detil/'); ?>" + id);
    }

    function hapus(data) {
        d = data;
        id = d.attr('data-id');
        $('a#hapus').attr('href', "<?= site_url('item_img/hapus/'); ?>" + id);
    }

    $(document).ready(function () {
        $('[tooltip]').tooltip();
    });

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
</body>
</html>