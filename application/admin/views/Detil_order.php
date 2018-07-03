<section>
    <div class="container-fluid">
        <h1>Order : #<?= $orders_noid; ?></h1>
        <hr>
        <div class="row">
            <div class="col">
                <div class="text-success">Tanggal Order :</div>
                <p class="small"><?= $orders->created_at; ?></p>
            </div>
            <div class="col">
                <div class="text-success">Tanggal Jatuh Tempo Pembayaran :</div>
                <p class="small">
                    <?= $duedate(); ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="text-success">Tujuan Pengiriman :</div>
                <p class="small">
                    <?= $pengiriman(); ?>
                </p>
            </div>
            <div class="col">
                <div class="text-success">Status :</div>
                <p class="small"><?php if ($orders->orders_status == 0): ?>
                        BELUM MENGISI ALAMAT PENGIRIMAN
                    <?php elseif ($orders->orders_status == 1): ?>
                        BELUM MENGISI METODE PENGIRIMAN & PEMBAYARAN
                    <?php elseif ($orders->orders_status == 2): ?>
                        PELANGGAN BELUM KONFIRMASI PEMBAYARAN
                    <?php elseif ($orders->orders_status == 3): ?>
                        ADMIN BELUM KONFIRMASI PEMBAYARAN
                    <?php elseif ($orders->orders_status == 4): ?>
                        ADMIN SEDANG MEMPROSES ORDER
                    <?php elseif ($orders->orders_status == 5): ?>
                        ADMIN BELUM KONFIRMASI PENGIRIMAN
                    <?php elseif ($orders->orders_status == 6): ?>
                        SUKSES (Telah dikirim)
                    <?php elseif ($orders->orders_status == 7): ?>
                        BATAL
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="text-success">Metode Pembayaran :</div>
                <p class="small"><?= $metode_pembayaran(); ?></p>
            </div>
            <div class="col">
                <div class="text-success">Metode Pengiriman :</div>
                <p class="small"><?= $jasa(); ?></p>
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
                    <?php foreach ($orders->order_detil as $detil): ?>
                        <tr>
                            <td><?= $item_detil($detil->item_detil_kode)->item->i_nama; ?></td>
                            <td><?= $detil->orders_detil_qty; ?></td>
                            <td id="rupiah"><?= $detil->orders_detil_harga; ?></td>
                            <td id="rupiah"><?= $detil->orders_detil_tharga; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col text-bold">Sub total</div>
                    <div class="col">
                        <div id="rupiah"><?= $biaya_subtotal(); ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-bold">Biaya pengiriman</div>
                    <div class="col">
                        <div id="rupiah"><?= $biaya_pengiriman(); ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-bold">Grand total</div>
                    <div class="col">
                        <div id="rupiah"><?= $biaya_subtotal() + $biaya_pengiriman(); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>

    // ------------------------------------------------------ //
    // Format Rupiah
    // ------------------------------------------------------ //
    var moneyFormat = wNumb({
        mark: ',',
        decimals: 0,
        thousand: '.',
        prefix: 'Rp. ',
        suffix: ''
    });

    $(document).ready(function () {
        $('[id="rupiah"]').each(function (index) {
            var value = parseInt($(this).html()),
                hasil = moneyFormat.to(value);

            $(this).html(hasil);
        })
    });
</script>