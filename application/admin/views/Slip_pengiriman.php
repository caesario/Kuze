<!DOCTYPE html>
<html>
<head>
    <title>Order : #<?= $orders_noid; ?></title>
</head>
<body>
<h2>#<?= $orders_noid; ?></h2>
<hr>
<table>
    <tr>
        <td width="200" height="30">Nama</td>
        <td height="30"><?= $nama_nomor()->nama; ?></td>
    </tr>
    <tr>
        <td height="30">Telpon / HP</td>
        <td height="30"><?= $nama_nomor()->kontak; ?></td>
    </tr>
    <tr>
        <td height="30">Alamat</td>
        <td height="30"><?= $pengiriman(); ?></td>
    </tr>
</table>
<hr>
<b><?= $brandname; ?></b><br><br>
<table>
    <tr>
        <td width="100">E-mail</td>
        <td>: <?= $email; ?><br></td>
    </tr>
    <tr>
        <td>Whatsapp</td>
        <td>: <?= $whatsapp; ?></td>
    </tr>
</table>

</body>
</html>