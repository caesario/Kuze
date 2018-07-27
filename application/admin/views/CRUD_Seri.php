<?php
$url = site_url('seri/simpan');
if ($submit == 'Ubah') {
    $id = $seris->s_kode;
    $img = $seris->s_image;
    $nama = $seris->s_nama;
    $hrg = $seris->s_harga;
} else if ($submit == 'Simpan') {
    $id = $kode;
    $img = '';
    $nama = '';
    $hrg = '';
}
?>
<style>
    #tbl_seri_wrapper {
        padding-left: 0;
        padding-right: 0;
    }
</style>
<form action="<?= $url; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="id" value="<?= $id; ?>">

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="nama">Kode Seri</label>
                <input type="text" class="form-control" name="nama" placeholder="Input Nomor Seri" value="<?= $nama; ?>"
                       required>
                <p>
                    <?= form_error('nama'); ?>
                </p>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" class="form-control" name="harga" placeholder="Input Harga Grosir"
                       value="<?= $hrg; ?>">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="">Item yang dipilih</label>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">Kode Item</th>
                    <th scope="col">Warna</th>
                    <th scope="col">Ukuran</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="form-group bg-light">
        <div class="table-responsive">
            <table id="tbl_seri" class="table table-sm">
                <thead>
                <tr>
                    <th scope="col"><input type="checkbox" name="select_all" value="1" id="pilih_item_semua"></th>
                    <th scope="col">Kode Item</th>
                    <th scope="col">Warna</th>
                    <th scope="col">Ukuran</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($items != NULL): ?>
                    <?php foreach ($items as $item): ?>
                        <?php foreach ($item->item_detil as $detil): ?>
                            <?php if (isset($item->item_detil) && $qty($detil->item_detil_kode) != 0): ?>
                                <tr>
                                    <td class="align-middle" id="<?= $item->i_kode; ?>"></td>
                                    <td class="align-middle"><?= $item->i_nama; ?></td>
                                    <td class="align-middle">
                                        <?php if (isset($warna($detil->item_detil_kode, $detil->w_kode)->w_nama)): ?>
                                            <?= $warna($detil->item_detil_kode, $detil->w_kode)->w_nama; ?>

                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= $detil->item_detil_ukuran; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-sm btn-primary"><?= $submit; ?></button>
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
    </div>
    <?php if (isset($berhasil)): ?>
        <p class="text-success"><?= $berhasil; ?></p>
    <?php endif; ?>
    <?php if (isset($gagal)): ?>
        <p class="text-danger"><?= $gagal; ?></p>
    <?php endif; ?>
</form>
<script>
    $(function () {
        $('#imageupload').fileupload({
            dataType: 'json',
            done: function (e, data) {
                $('#filename').attr("src", "<?= base_url('upload/');?>" + data.result.file_name);
                $('#inputfilename').attr("value", data.result.file_name);
            },
            progressall: function (e, data) {
                var showimgsrc = $('#filename');
                var hideupload = $('div.custom-file');
                var showprogress = $('div.progress');

                hideupload.hide();
                showprogress.show();
                showimgsrc.show();

                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress').css(
                    'width',
                    progress + '%'
                ).text(progress + '%');
            }
        });
    });
</script>
<script>
    // ------------------------------------------------------ //
    // Data table
    // ------------------------------------------------------ //
    var table = $('#tbl_seri').DataTable({
        'columnDefs': [{
            'targets': 0,
            'searchable': false,
            'orderable': false,
            'className': 'dt-body-center',
            'render': function (data, type, full, meta) {
                return '<input type="checkbox" name="pilih_item[]" value="' + $('').attr('id') + '">';
            }
        }],
        "ordering": false,
        "info": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian.json"
        }
    });
    // Handle click on "Select all" control
    $('#pilih_item_semua').on('click', function () {
        // Get all rows with search applied
        var rows = table.rows({'search': 'applied'}).nodes();
        // Check/uncheck checkboxes for all rows in the table
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    // Handle click on checkbox to set state of "Select all" control
    $('#tbl_seri tbody')
        .on('change', 'input[type="checkbox"]', function () {
            // If checkbox is not checked
            if (!this.checked) {
                var el = $('#pilih_item_semua').get(0);
                // If "Select all" control is checked and has 'indeterminate' property
                if (el && el.checked && ('indeterminate' in el)) {
                    // Set visual state of "Select all" control
                    // as 'indeterminate'
                    el.indeterminate = true;
                }
            }
        })
        .on('click', 'tr', function () {
            $(this).find('input[type="checkbox"]').click();
            $(this).find('')

        });

</script>
