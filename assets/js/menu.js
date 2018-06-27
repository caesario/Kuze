// ------------------------------------------------------ //
// Menu
// ------------------------------------------------------ //
$(document).ready(function () {

    // MENU MISC
    var c_misc = $.cookie('misc_menu');
    var $menu_misc = $('#side-main-menu > li:nth-child(2) > a');
    var $ul_misc = $('#misc');

    if (c_misc == 'expanded') {
        $menu_misc.removeClass('collapsed').attr('aria-expanded', 'true');
        $ul_misc.addClass('show');
    }

    if (c_misc == 'collapsed') {
        $menu_misc.addClass('collapsed').attr('aria-expanded', 'false');
        $ul_misc.removeClass('show');
    }

    $menu_misc.click(function () {
        if ($menu_misc.hasClass('collapsed')) {
            $.cookie('misc_menu', 'expanded', {path: '/', expires: 100});
        } else {
            $.cookie('misc_menu', 'collapsed', {path: '/', expires: 100});
        }
    });
    // END MISC

    // ITEM
    // var c_item = $.cookie('item_menu');
    // var $menu_item = $('#side-main-menu > li:nth-child(3) > a');
    // var $ul_item = $('#item');
    //
    // if (c_item == 'expanded') {
    //     $menu_item.removeClass('collapsed').attr('aria-expanded', 'true');
    //     $ul_item.addClass('show');
    // }
    //
    // if (c_item == 'collapsed') {
    //     $menu_item.addClass('collapsed').attr('aria-expanded', 'false');
    //     $ul_item.removeClass('show');
    // }
    //
    // $menu_item.click(function () {
    //     if ($menu_item.hasClass('collapsed')) {
    //         $.cookie('item_menu', 'expanded', {path: '/', expires: 100});
    //     } else
    //     {
    //         $.cookie('item_menu', 'collapsed', {path: '/', expires: 100});
    //     }
    // });
    // END ITEM

    // MENU TRANSAKSI
    var c_transaksi = $.cookie('transaksi_menu');
    var $menu_transaksi = $('#side-main-menu > li:nth-child(4) > a');
    var $ul_transaksi = $('#transaksi');

    if (c_transaksi == 'expanded') {
        $menu_transaksi.removeClass('collapsed').attr('aria-expanded', 'true');
        $ul_transaksi.addClass('show');
    }

    if (c_transaksi == 'collapsed') {
        $menu_transaksi.addClass('collapsed').attr('aria-expanded', 'false');
        $ul_transaksi.removeClass('show');
    }

    $menu_transaksi.click(function () {
        if ($menu_transaksi.hasClass('collapsed')) {
            $.cookie('transaksi_menu', 'expanded', {path: '/', expires: 100});
        } else {
            $.cookie('transaksi_menu', 'collapsed', {path: '/', expires: 100});
        }
    });

    // MENU PELANGGAN
    var c_pelanggan = $.cookie('pelanggan_menu');
    var $menu_pelanggan = $('#side-main-menu > li:nth-child(5) > a');
    var $ul_pelanggan = $('#pelanggan');

    if (c_pelanggan == 'expanded') {
        $menu_pelanggan.removeClass('collapsed').attr('aria-expanded', 'true');
        $ul_pelanggan.addClass('show');
    }

    if (c_pelanggan == 'collapsed') {
        $menu_pelanggan.addClass('collapsed').attr('aria-expanded', 'false');
        $ul_pelanggan.removeClass('show');
    }

    $menu_pelanggan.click(function () {
        if ($menu_pelanggan.hasClass('collapsed')) {
            $.cookie('pelanggan_menu', 'expanded', {path: '/', expires: 100});
        } else {
            $.cookie('pelanggan_menu', 'collapsed', {path: '/', expires: 100});
        }
    });
});