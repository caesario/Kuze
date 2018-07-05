<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['forgot'] = 'auth/forgot';
$route['logout'] = 'auth/logout';
$route['cari'] = 'pencarian';
$route['produk-terbaru'] = 'home/produkbaru';
$route['produk-terbaru/item/(:any)/detil'] = 'home/item/$1';
$route['produk-terbaru/item/(:any)/add_to_cart'] = 'cart/add';
$route['hot-item/item/(:any)/detil'] = 'home/item/$1';
$route['hot-item/item/(:any)/add_to_cart'] = 'cart/add/$1';
$route['item/(:any)/detil'] = 'home/item/$1';
$route['item/(:any)/add_to_cart'] = 'cart/add/$1';
$route['kategori/(:any)'] = 'kategori/get_item/$1';
$route['kategori/(:any)/item/(:any)/detil'] = 'kategori/get_item_detil/$1/$2';
$route['kategori/(:any)/item/(:any)/add_to_cart'] = 'cart/add';
$route['cart/(:any)/delete'] = 'cart/delete/$1';
$route['checkout/(:any)/alamat_pengiriman'] = 'alamat/get/$1';
$route['checkout/(:any)/alamat_pengiriman/simpan'] = 'alamat/simpan';
$route['checkout/(:any)/alamat_pengiriman/alamat_simpan'] = 'alamat/alamat_simpan';
$route['checkout/(:any)/ongkir_transfer'] = 'ongkir_transfer/get/$1';
$route['checkout/(:any)/ongkir_transfer/simpan'] = 'ongkir_transfer/simpan';
$route['checkout/(:any)/konfirmasi_pembayaran'] = 'konfirmasi/get/$1';
$route['checkout/(:any)/konfirmasi_pembayaran/simpan'] = 'konfirmasi/simpan';
$route['checkout/(:any)/sukses'] = 'konfirmasi/sukses';
$route['artikel/(:any)'] = 'artikel/get/$1';
$route['blog/(:any)'] = 'artikel/get/$1';
$route['resi/(:any)/detil'] = 'resi/get/$1';
$route['riwayat/(:any)/detil'] = 'Detil_item';
$route['pending/(:any)/detil'] = 'Detil_item';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
