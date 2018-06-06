<?php
$url = site_url('item/simpan_detil');
if ($submit == 'Ubah') {
    $id = $item_detil->ide_kode;
    $warna = $item_detil->w_kode;
    $ukuran = $item_detil->u_kode;
    $seri = $item_detil->s_kode;
} else if ($submit == 'Simpan') {
    $id = $kode;
    $warna = '';
    $ukuran = '';
    $seri = '';
}
?>
<form action="<?= $url; ?>" method="post">
    <input type="hidden" name="token_fg" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <div class="row">
        <div class="col form-group">
            <label for="warna">Warna</label>
            <select name="warna" id="warna" class="form-control small" required>
                <option value="" disabled>Pilih Warna</option>
                <?php foreach ($this->warna->get_all() as $katwarna): ?>
                    <option value="<?= $katwarna->w_kode; ?>" <?= $warna != '' && $warna == $katwarna->w_kode ? 'selected' : ''; ?> ><?= $katwarna->w_nama; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col form-group">
            <label for="ukuran">Ukuran</label>
            <select name="ukuran" id="ukuran" class="form-control small" required>
                <option value="" disabled>Pilih Ukuran</option>
                <?php foreach ($this->ukuran->get_all() as $katukuran): ?>
                    <option value="<?= $katukuran->u_kode; ?>" <?= $ukuran != '' && $ukuran == $katukuran->u_kode ? 'selected' : ''; ?> ><?= $katukuran->u_nama; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col form-group">
            <label for="seri">Seri</label>
            <select name="seri" id="seri" class="form-control small">
                <option value="0">None</option>
                <?php foreach ($this->seri->get_all() as $katseri): ?>
                    <option value="<?= $katseri->s_kode; ?>" <?= $seri != '' && $seri == $katseri->s_kode ? 'selected' : ''; ?> ><?= $katseri->s_nama; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <input type="hidden" id="counter" name="counter" value="1">
        <button type="submit" class="btn btn-primary btn-sm"><?= $submit; ?></button>
        <button type="button" onclick="window.location.reload()" class="btn btn-danger btn-sm">Tutup</button>
    </div>
</form>
<link rel="stylesheet" href="<?= base_url('assets/vendor/select/css/multi-select.css'); ?>">
<script src="<?= base_url('assets/vendor/select/js/jquery.multi-select.js'); ?>"></script>
<script>
    $(document).ready(function () {
        $('select#kategori').multiSelect();
    });

    var $table = $('#tabel').find("tbody");

    $('#baru_detil').click(function () {
        var $trLast = $table.find("tr:last"),
            $trNew = $trLast.clone();

        $trLast.after($trNew);

        var counter = parseInt($('#counter').val());
        $('#counter').val(counter + 1);

    });

    function hapus_detil($data) {
        if ($('#tabel > tbody > tr').length > 1) {
            $('#tabel > tbody > tr:last')
                .prev()
                .find('input, select')
                .attr('disabled', false);
            $data.closest('tr').remove();
        }
    }
</script>