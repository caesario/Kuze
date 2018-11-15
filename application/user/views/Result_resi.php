<div class="span8" id="detiltracking">
    <div class="visible-desktop">
        <div class="ro-result">
            <p>
                <span class="big">Hasil pelacakan paket</span>
                <span class="pull-right"><strong><?= $query_name; ?></strong></span>
            </p>
        </div>
    </div>
    <div id="ro-lacakpaket-result">
        <table class="table table-bordered table-hover table-striped">
            <tbody>
            <tr>
                <td>Nomor resi</td>
                <td><?= $waybill_number; ?></td>
            </tr>
            <tr>
                <td>Jenis layanan</td>
                <td><?= $service_code; ?></td>
            </tr>
            <tr>
                <td>Tanggal pengiriman</td>
                <td><?= $waybill_datetime; ?></td>
            </tr>
            <tr>
                <td>Berat kiriman</td>
                <td><?= $weight; ?> kg</td>
            </tr>
            <tr>
                <td>Nama pengirim</td>
                <td><?= $shipper_name; ?></td>
            </tr>
            <tr>
                <td>Kota asal pengirim</td>
                <td><?= $shipper_city; ?></td>
            </tr>
            <tr>
                <td>Nama penerima</td>
                <td><?= $receiver_name; ?></td>
            </tr>
            <tr>
                <td>Alamat penerima</td>
                <td><?= $address; ?></td>
            </tr>
            </tbody>
        </table>
        <div class="bor"></div>
        <p><strong>Status pengiriman</strong></p>
        <table class="table table-bordered table-hover table-striped">
            <tbody>
            <tr>
                <td>Status</td>
                <td><?= $status; ?></td>
            </tr>
            <tr>
                <td>Nama penerima</td>
                <td><?= $pod_receiver; ?></td>
            </tr>
            <tr>
                <td>Tanggal diterima</td>
                <td><?= $pod_datetime; ?></td>
            </tr>
            </tbody>
        </table>
        <div class="bor"></div>
        <p><strong>Riwayat pengiriman</strong></p>
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kota</th>
                <th>Keterangan</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($manifests as $manifest): ?>
                <tr>
                    <td><?= $manifest['manifest_date'] . ' ' . $manifest['manifest_time']; ?></td>
                    <td><?= $manifest['city_name']; ?></td>
                    <td><?= $manifest['manifest_description']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#btnprint').click(function () {
            $('#detiltracking').print();
        })
    })
</script>