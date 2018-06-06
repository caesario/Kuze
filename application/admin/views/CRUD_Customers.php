<?php
$url = site_url('customers/simpan');
if ($submit == 'Ubah') {
    $id = $customers->p_kode;
    $tipe = $customers->p_tipe;
    $nama = $customers->p_nama;
    $username = $customers->p_username;
    $password = $customers->p_password;
    $email = $customers->p_email;
} else if ($submit == 'Simpan') {
    $id = $kode;
    $tipe = '';
    $nama = '';
    $username = '';
    $password = '';
    $email = '';
}
?>

<form action="<?= $url; ?>" method="post">
    <input type="hidden" name="token_fg" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <div class="form-group">
        <label for="tipe">Tipe</label>
        <select name="tipe" id="tipe" class="form-control" required>
            <option value="" <?= $tipe == '' ? 'selected' : ''; ?>>Pilih Tipe</option>
            <option value="1" <?= $tipe == 1 ? 'selected' : ''; ?>>VIP</option>
            <option value="2" <?= $tipe == 2 ? 'selected' : ''; ?>>Reseller</option>
        </select>
        <p>
            <?= form_error('tipe'); ?>
        </p>
    </div>
    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" name="nama" placeholder="Input Nama" value="<?= $nama; ?>" required>
        <p>
            <?= form_error('nama'); ?>
        </p>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Input Password"
               value="<?= $password; ?>" required>
        <p>
            <?= form_error('password'); ?>
        </p>
    </div>
    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" class="form-control" name="email" placeholder="Input E-mail" value="<?= $email; ?>"
               required>
        <p>
            <?= form_error('email'); ?>
        </p>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><?= $submit; ?></button>
        <button type="button" onclick="window.location.reload()" class="btn btn-danger">Tutup</button>
    </div>
    <?php if (isset($berhasil)): ?>
        <p class="text-success"><?= $berhasil; ?></p>
    <?php endif; ?>
    <?php if (isset($gagal)): ?>
        <p class="text-danger"><?= $gagal; ?></p>
    <?php endif; ?>
</form>
