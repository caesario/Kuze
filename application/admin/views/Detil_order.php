<section>
    <div class="container-fluid">
        <h1>Order : #<?= $order_noid; ?></h1>
        <hr>
        <div class="row">
            <div class="col">
                <div class="text-success">Nama Pelanggan :</div>
                <p class="small"><b><?= $order_pelanggan; ?></b></p>
            </div>

            <div class="col">
                <div class="text-success">Status :</div>
                <p class="small"><?php if ($status == 0): ?>
                        <b>BELUM MENGISI ALAMAT PENGIRIMAN</b>
                    <?php elseif ($status == 1): ?>
                        <b>BELUM MENGISI METODE PENGIRIMAN & PEMBAYARAN</b>
                    <?php elseif ($status == 2): ?>
                        <b>PELANGGAN BELUM KONFIRMASI PEMBAYARAN</b>
                    <?php elseif ($status == 3): ?>
                        <b>ADMIN BELUM KONFIRMASI PEMBAYARAN</b>
                    <?php elseif ($status == 4): ?>
                        <b>ADMIN SEDANG MEMPROSES ORDER</b>
                    <?php elseif ($status == 5): ?>
                        <b>ADMIN BELUM KONFIRMASI PENGIRIMAN</b>
                    <?php elseif ($status == 6): ?>
                        <b>TELAH DIKIRIM</b>
                    <?php elseif ($status == 7): ?>
                        <b>BATAL</b>
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="text-success">Tanggal Order :</div>
                <p class="small"><?= $createdate; ?></p>
            </div>
            <div class="col">
                <div class="text-success">Tanggal Jatuh Tempo Pembayaran :</div>
                <p class="small">
                    <?= $duedate; ?>
                </p>
            </div>
        </div>

        <div class="row">

            <div class="col">
                <div class="text-success">Metode Pembayaran :</div>
                <p class="small"><?= $metode_pembayaran; ?></p>
            </div>
            <div class="col">
                <div class="text-success">Metode Pengiriman :</div>
                <p class="small"><?= $jasa; ?></p>
            </div>

        </div>

        <div class="row mb-5">
            <div class="col">
                <div class="text-success">Detail Item :</div>
                <table id="tables" class="table table-sm">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th>QTY</th>
                        <th>Harga Satuan</th>
                        <th>Harga Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($order_detils as $detil): ?>
                        <tr>
                            <td><?= $detil['orders_item_nama']; ?></td>
                            <td><?= $detil['orders_detil_qty']; ?></td>
                            <td id="modalrupiah"><?= $detil['orders_detil_harga']; ?></td>
                            <td id="modalrupiah"><?= $detil['orders_detil_tharga']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="text-success">Tujuan Pengiriman :</div>
                <p class="small">
                    <?= $pengiriman; ?>
                </p>
            </div>
            <div class="col">
                <div class="text-success">Nama Pengirim :</div>
                <p class="small">
                    <?php if ($pengiriman_kontak->orders_pengiriman_s_nama != NULL): ?>
                        <?= $pengiriman_kontak->orders_pengiriman_s_nama; ?><br>
                        <?= $pengiriman_kontak->orders_pengiriman_s_kontak; ?>
                    <?php elseif ($pengiriman_kontak->orders_pengiriman_r_nama != NULL): ?>
                        <?= $pengiriman_kontak->orders_pengiriman_r_nama; ?><br>
                        <?= $pengiriman_kontak->orders_pengiriman_r_kontak; ?>
                    <?php else: ?>
                        Belum ada pengirim
                    <?php endif; ?>
                </p>
            </div>
            <div class="col">
                <div class="text-success">Nama Penerima :</div>
                <p class="small">
                    <?php if ($pengiriman_kontak->orders_pengiriman_r_nama != NULL): ?>
                        <?= $pengiriman_kontak->orders_pengiriman_r_nama; ?><br>
                        <?= $pengiriman_kontak->orders_pengiriman_r_kontak; ?>
                    <?php else: ?>
                        Belum ada penerima
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <div class="row justify-content-end">
            <div class="col-6 ">
                <div class="row">
                    <div class="col text-bold">Kode Unik</div>
                    <div class="col">
                        <b id="modalrupiah"><?= $order_uniq; ?></b>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col text-bold">Sub total</div>
                    <div class="col">
                        <div id="modalrupiah"><?= $biaya_subtotal; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-bold">Potongan</div>
                    <div class="col">
                        <div id="modalrupiah"><?= $diskon_harga; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-bold">Biaya pengiriman</div>
                    <div class="col">
                        <div id="modalrupiah"><?= $biaya_pengiriman; ?></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col text-bold">Grand total</div>
                    <div class="col">
                        <div id="modalrupiah"><?= $grand_total; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>

    $(function () {
        $('[id="modalrupiah"]').each(function (index) {
            var value = parseInt($(this).html()),
                hasil = moneyFormat.to(value);

            $(this).html(hasil);
        })
    });
</script>