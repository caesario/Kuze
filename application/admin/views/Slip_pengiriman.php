<!DOCTYPE html>
<html>
<head>
    <title>Order : #<?= $orders_noid; ?></title>
</head>

<style>
    body {
        font-size: 18px;
    }
</style>

<body>
<h2 style="margin-bottom: 0px;">Alamat Pengiriman</h2>
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
    <tr>
        <td height="30">Jenis Pengiriman</td>
        <td height="30"><?= $order_ongkir_nama; ?></td>
    </tr>
</table>
<hr>
<b>KUZE.CO</b><br>
<table>
    <tr>
        <td><?= $whatsapp; ?></td>
    </tr>
</table>

</body>
</html>