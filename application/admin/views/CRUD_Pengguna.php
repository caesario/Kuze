<?php
$url = site_url('pengguna/simpan');
if ($submit == 'Ubah') {
    $id = $users->pengguna_kode;
    $nama = $users->pengguna_nama;
    $username = $users->pengguna_username;
    $password = $users->pengguna_password;
    $email = $users->pengguna_email;
} else if ($submit == 'Simpan') {
    $id = $kode;
    $nama = '';
    $username = '';
    $password = '';
    $email = '';
}
?>

<form action="<?= $url; ?>" method="post">
    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" name="nama" placeholder="Input Nama" value="<?= $nama; ?>" required>
        <p>
            <?= form_error('nama'); ?>
        </p>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" placeholder="Input Username" value="<?= $username; ?>"
               required>
        <p>
            <?= form_error('username'); ?>
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
