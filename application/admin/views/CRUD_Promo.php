<?php
$url = site_url('bank/simpan');
if ($submit == 'Ubah') {
    $promo_kode = $promo->promo_kode;
    $promo_pot_rp = $promo->promo_pot_rp;
    $promo_pot_persen = $promo->promo_pot_persen;
    $isaktif = $promo->promo_aktif;
} else if ($submit == 'Simpan') {
    $promo_kode = '';
    $promo_pot_rp = '';
    $promo_pot_persen = '';
    $isaktif = 1;
}
?>

<form action="<?= $url; ?>" method="post">
    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
    <div class="form-group">
        <label for="promo_kode">Kode Promo</label>
        <input type="text" class="form-control" name="promo_kode" id="promo_kode" value="<?= $promo_kode; ?>"
               placeholder="Input Kode Promo)">
    </div>
    <div class="form-group">
        <label for="promo_pot_rp">Potongan Nominal (Rp)</label>
        <input type="number" class="form-control" name="promo_pot_rp" id="promo_pot_rp" value="<?= $promo_pot_rp; ?>"
               placeholder="Input Potongan dalam bentuk nominal">
    </div>
    <div class="form-group">
        <label for="promo_pot_persen">Potongan Persen (%)</label>
        <input type="number" class="form-control" name="promo_pot_persen" id="promo_pot_persen"
               value="<?= $promo_pot_persen; ?>"
               placeholder="Input Nomor Rekening">
    </div>
    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="aktif" value="1"
                   id="aktif" <?= $isaktif == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label" for="aktif">
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
