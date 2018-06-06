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
    <table id="tables" class="table table-sm table-borderless">
        <thead>
        <tr>
            <th scope="col">Foto</th>
            <th scope="col">Default</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php if ($item_imgs != NULL): ?>
            <?php foreach ($item_imgs as $img): ?>
                <tr>
                    <td><img src="<?= base_url('upload/' . $img->ii_url); ?>" alt="<?= $img->ii_nama; ?>" height="100"
                             width="100"></td>
                    <td class="align-middle"><?= $img->ii_default == 0 ? '<i class="fas fa-times"></i>' : '<i class="fas fa-check"></i>'; ?></td>
                    <td class="align-middle">
                        <a href="<?= site_url('item_img/set_default/' . $img->i_kode . '/' . $img->ii_kode); ?>"
                           onclick="utama($(this))" data-id="<?= $img->ii_kode; ?>">
                            Jadikan utama
                        </a> |
                        <a data-toggle="modal" title="Hapus <?= $title_page; ?>" href="#"
                           onclick="hapus($(this))" data-target="#hapus"
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