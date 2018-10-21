<div class="container-fluid">
    <h5 class="mt-2">Confirm Payment Detail</h5>
    <hr>
    <div class="row">
        <div class="col">
            <div class="text-success">Bank Account</div>
            <p class="small">
                <?= $order->orders_bukti_bank_nama; ?>
            </p>
        </div>
        <div class="col">
            <div class="text-success">Account Name :</div>
            <p class="small">
                <?= $order->orders_bukti_nama_rek; ?>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="text-success">Account Number :</div>
            <p class="small">
                <?= $order->orders_bukti_no_rek; ?>
            </p>
        </div>
        <div class="col">
            <div class="text-success">Grand Total :</div>
            <p class="small" id="modalrupiah">
                <?= $order->orders_bukti_nominal; ?>
            </p>
        </div>
    </div>
    <br>
    <p class="">Apakah anda yakin ingin melanjutkan proses ini?</p>
</div>
<script>

    $('p#modalrupiah').each(function (index) {
        var value = parseInt($(this).html()),
            hasil = moneyFormat.to(value);

        $(this).html(hasil);
    });


</script>