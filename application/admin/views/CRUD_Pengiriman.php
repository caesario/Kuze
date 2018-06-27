<form action="<?= site_url('order/resi_pengiriman'); ?>" method="post">
    <input type="hidden" name="ecommerce_eazy" value="<?= $this->security->get_csrf_hash(); ?>">

    <input type="hidden" name="orders_noid" value="<?= $orders_noid; ?>">
    <div class="form-group">
        <label for="resi">Nomor Resi</label>
        <input class="form-control" type="text" name="resi" id="resi" placeholder="Input nomor resi">
    </div>
    <div class="form-group">
        <button class="btn btn-sm btn-primary" type="submit">Kirim</button>
        <button class="btn btn-sm btn-danger" type="button" data-dismiss="modal">Batalkan</button>
    </div>
</form>