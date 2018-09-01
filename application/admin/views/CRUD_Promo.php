<?php
$url = site_url('promo/simpan');
if ($submit == 'Ubah') {
    $promo_nama = $promo->promo_nama;
    $promo_rate = $promo->promo_rate;
    $promo_nominal = $promo->promo_nominal;
    $promo_aktif = $promo->promo_aktif;
} else if ($submit == 'Simpan') {
    $promo_nama = '';
    $promo_rate = '';
    $promo_nominal = '';
    $promo_aktif = 1;
}
?>

<form action="<?= $url; ?>" method="post">
    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
    <div class="form-group">
        <label for="promo_kode">Kode Promo</label>
        <input type="text" class="form-control" name="promo_nama" id="promo_nama" value="<?= $promo_nama; ?>"
               placeholder="Input Kode Promo)">
    </div>
    <div class="form-group">
        <label for="promo_rate">Potongan Rate (%)</label>
        <input type="number" max="100" maxlength="100" class="form-control" name="promo_rate" id="promo_rate"
               value="<?= $promo_rate; ?>"
               placeholder="Input Potongan Rate">
    </div>
    <div class="form-group">
        <label for="promo_rate">Potongan Nominal (Rp)</label>
        <input type="number" class="form-control" name="promo_nominal" id="promo_nominal"
               value="<?= $promo_nominal; ?>"
               placeholder="Input Potongan Nominal">
    </div>
    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="promo_aktif" value="1"
                   id="promo_aktif" <?= $promo_aktif == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label" for="promo_aktif">
                Aktif
            </label>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-sm btn-primary"><?= $submit; ?></button>
        <button type="button" onclick="window.location.reload()" class="btn btn-sm btn-danger">Tutup</button>
    </div>
    <?php if (isset($berhasil)): ?>
        <p class="text-success"><?= $berhasil; ?></p>
    <?php endif; ?>
    <?php if (isset($gagal)): ?>
        <p class="text-danger"><?= $gagal; ?></p>
    <?php endif; ?>
</form>
<script>
    $(document).ready(function () {
        $('#promo_rate').keypress(function () {
            $('#promo_nominal').val('0');
        });

        $('#promo_nominal').keypress(function () {
            $('#promo_rate').val('0');
        });
    })
</script>
