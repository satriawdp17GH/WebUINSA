<?php

use CodeIgniter\Router\RouteCollection;

/**
 * ARUNA — app/Config/Routes.php (CodeIgniter 4)
 *
 * @var RouteCollection $routes
 *
 * PRASYARAT
 * 1) Daftarkan filter di app/Config/Filters.php pada $aliases:
 *      'auth' => \App\Filters\AuthFilter::class,   // wajib login
 *      'role' => \App\Filters\RoleFilter::class,   // 'role:seller', 'role:admin'
 *    RoleFilter sebaiknya sekaligus mengecek login dan status akun.
 * 2) Matikan auto routing: Config\Routing::$autoRoute = false.
 * 3) Webhook pembayaran tidak mengirim token CSRF. Kecualikan di
 *    Filters.php: $globals['before']['csrf'] = ['except' => ['webhook/*']].
 * 4) Form HTML hanya mengenal GET/POST, makanya rute halaman web di atas
 *    memakai POST. Rute /api/v1 memakai PUT/PATCH/DELETE asli: panggil dengan
 *    fetch() dan sertakan header X-CSRF-TOKEN (jika CSRF aktif) atau token
 *    bearer jika nanti memakai token.
 *
 * KONVENSI URL
 *   Halaman pembeli      : bahasa Indonesia (/jelajahi, /gerobak, /pesanan)
 *   Dashboard            : /seller/... dan /admin/...
 *   API (React/AJAX)     : /api/v1/... (JSON)
 *
 * Jika dashboard seller/admin nanti dipindah ke React (build ditaruh di
 * public/dashboard), hapus group 'seller' dan 'admin' di bawah dan ganti dengan
 * satu rute penangkap, mis.:
 *   $routes->get('dashboard/(:any)', 'SpaController::index', ['filter' => 'auth']);
 */

// =====================================================================
// 1. PUBLIK (tanpa login)
// =====================================================================
$routes->get('/', 'Home::index');

// Jelajah UMKM
$routes->get('jelajahi', 'Merchants::index');
$routes->get('kategori/(:segment)', 'Merchants::category/$1');
$routes->get('umkm/(:segment)', 'Merchants::show/$1');

// Gerobak (fitur pembeda ARUNA)
$routes->get('gerobak', 'Gerobak::index');
$routes->get('gerobak/(:segment)', 'Gerobak::show/$1');

// Produk
$routes->get('produk', 'Products::index');
$routes->get('produk/(:segment)', 'Products::show/$1');

// Pencarian
$routes->get('cari', 'Search::index');

// Halaman statis
$routes->get('tentang', 'Pages::about');
$routes->get('faq', 'Pages::faq');
$routes->get('kebijakan-privasi', 'Pages::privacy');
$routes->get('syarat-ketentuan', 'Pages::terms');
$routes->get('hubungi-kami', 'Pages::contact');
$routes->post('hubungi-kami', 'Pages::sendContact');

// =====================================================================
// 2. AUTENTIKASI
// =====================================================================
$routes->get('masuk', 'Auth::login');
$routes->post('masuk', 'Auth::attemptLogin');
$routes->get('daftar', 'Auth::register');
$routes->post('daftar', 'Auth::attemptRegister');
$routes->get('keluar', 'Auth::logout');

// Login/daftar lewat OTP nomor HP (hapus jika tidak dipakai)
$routes->post('masuk/otp', 'Auth::sendOtp');
$routes->post('masuk/otp/verifikasi', 'Auth::verifyOtp');

// Lupa & atur ulang sandi
$routes->get('lupa-sandi', 'Auth::forgot');
$routes->post('lupa-sandi', 'Auth::sendReset');
$routes->get('atur-ulang-sandi/(:segment)', 'Auth::reset/$1');
$routes->post('atur-ulang-sandi', 'Auth::attemptReset');

// Pendaftaran UMKM (butuh akun). Parameter: umkm = toko tetap, gerobak = keliling.
$routes->group('gabung', ['filter' => 'auth'], static function ($routes) {
    $routes->get('(umkm|gerobak)', 'Onboarding::form/$1');
    $routes->post('(umkm|gerobak)', 'Onboarding::store/$1');
    $routes->get('status', 'Onboarding::status');
});

// =====================================================================
// 3. PEMBELI (wajib login)
// =====================================================================
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // Keranjang & checkout (aksi tambah/ubah/hapus lewat API, lihat bagian 6)
    $routes->get('keranjang', 'Cart::index');
    $routes->get('checkout', 'Checkout::index');
    $routes->post('checkout', 'Checkout::process');
    $routes->get('checkout/bayar/(:segment)', 'Checkout::pay/$1');

    // Pesanan
    $routes->get('pesanan', 'Orders::index');
    $routes->get('pesanan/(:segment)', 'Orders::show/$1');
    $routes->post('pesanan/(:segment)/batal', 'Orders::cancel/$1');
    $routes->post('pesanan/(:segment)/ulasan', 'Orders::review/$1');

    // Favorit
    $routes->get('favorit', 'Favorites::index');

    // Akun & alamat
    $routes->get('akun', 'Account::index');
    $routes->post('akun', 'Account::update');
    $routes->get('akun/alamat', 'Addresses::index');
    $routes->post('akun/alamat', 'Addresses::store');
    $routes->post('akun/alamat/(:num)', 'Addresses::update/$1');
    $routes->post('akun/alamat/(:num)/hapus', 'Addresses::delete/$1');
    $routes->post('akun/alamat/(:num)/utama', 'Addresses::makeDefault/$1');

    // Notifikasi
    $routes->get('notifikasi', 'Notifications::index');
});

// Webhook payment gateway (tanpa login, tanpa CSRF; verifikasi signature di controller)
$routes->post('webhook/pembayaran/(:segment)', 'Webhooks::payment/$1');

// =====================================================================
// 4. DASHBOARD SELLER (role: seller)
// =====================================================================
$routes->group('seller', [
    'namespace' => 'App\Controllers\Seller',
    'filter'    => 'role:seller',
], static function ($routes) {
    $routes->get('/', 'Dashboard::index');

    // Produk
    $routes->get('produk', 'Products::index');
    $routes->get('produk/baru', 'Products::new');
    $routes->post('produk', 'Products::create');
    $routes->get('produk/(:num)/ubah', 'Products::edit/$1');
    $routes->post('produk/(:num)', 'Products::update/$1');
    $routes->post('produk/(:num)/hapus', 'Products::delete/$1');
    $routes->post('produk/(:num)/ketersediaan', 'Products::toggle/$1');

    // Pesanan masuk
    $routes->get('pesanan', 'Orders::index');
    $routes->get('pesanan/(:segment)', 'Orders::show/$1');
    $routes->post('pesanan/(:segment)/status', 'Orders::updateStatus/$1');

    // Profil toko & jam buka
    $routes->get('toko', 'Store::edit');
    $routes->post('toko', 'Store::update');
    $routes->get('toko/jam-buka', 'Store::hours');
    $routes->post('toko/jam-buka', 'Store::saveHours');
    $routes->post('toko/buka-tutup', 'Store::toggleOpen');

    // Lokasi gerobak (hanya untuk merchants.type = 'gerobak'; cek di controller)
    $routes->get('lokasi', 'Location::index');
    $routes->post('lokasi', 'Location::update');
    $routes->post('lokasi/jualan', 'Location::toggleSelling');

    // Laporan & pendapatan
    $routes->get('laporan', 'Reports::index');
    $routes->get('pendapatan', 'Earnings::index');
});

// =====================================================================
// 5. DASHBOARD ADMIN (role: admin)
// =====================================================================
$routes->group('admin', [
    'namespace' => 'App\Controllers\Admin',
    'filter'    => 'role:admin',
], static function ($routes) {
    $routes->get('/', 'Dashboard::index');

    // Verifikasi & kelola UMKM
    $routes->get('umkm', 'Merchants::index');
    $routes->get('umkm/(:num)', 'Merchants::show/$1');
    $routes->post('umkm/(:num)/setujui', 'Merchants::approve/$1');
    $routes->post('umkm/(:num)/tolak', 'Merchants::reject/$1');
    $routes->post('umkm/(:num)/suspend', 'Merchants::suspend/$1');
    $routes->post('umkm/(:num)/unggulan', 'Merchants::toggleFeatured/$1');

    // Pengguna
    $routes->get('pengguna', 'Users::index');
    $routes->get('pengguna/(:num)', 'Users::show/$1');
    $routes->post('pengguna/(:num)/status', 'Users::updateStatus/$1');

    // Pesanan, pembayaran, pengantaran
    $routes->get('pesanan', 'Orders::index');
    $routes->get('pesanan/(:segment)', 'Orders::show/$1');
    $routes->get('pembayaran', 'Payments::index');
    $routes->get('pengantaran', 'Deliveries::index');

    // Kategori
    $routes->get('kategori', 'Categories::index');
    $routes->post('kategori', 'Categories::create');
    $routes->post('kategori/(:num)', 'Categories::update/$1');
    $routes->post('kategori/(:num)/hapus', 'Categories::delete/$1');
});

// =====================================================================
// 6. API v1 (JSON) — dipakai AJAX halaman pembeli dan dashboard React
//    Dibuat sebagai group terpisah (bukan bersarang) agar opsi filter
//    dan namespace masing-masing group pasti terbaca.
// =====================================================================

// 6a. API publik
$routes->group('api/v1', ['namespace' => 'App\Controllers\Api\V1'], static function ($routes) {
    $routes->get('categories', 'Categories::index');

    // Query: lat, lng, radius, type (toko|gerobak), category, q, open, page
    $routes->get('merchants', 'Merchants::index');
    $routes->get('merchants/(:segment)', 'Merchants::show/$1');
    $routes->get('merchants/(:segment)/products', 'Merchants::products/$1');

    $routes->get('gerobak/nearby', 'Gerobak::nearby');

    $routes->get('products', 'Products::index');
    $routes->get('products/popular', 'Products::popular');

    $routes->get('search', 'Search::index');
});

// 6b. API pembeli (login)
$routes->group('api/v1', [
    'namespace' => 'App\Controllers\Api\V1',
    'filter'    => 'auth',
], static function ($routes) {
    $routes->get('me', 'Me::show');
    $routes->put('me', 'Me::update');

    // Keranjang
    $routes->get('cart', 'Cart::show');
    $routes->post('cart/items', 'Cart::add');
    $routes->patch('cart/items/(:num)', 'Cart::update/$1');
    $routes->delete('cart/items/(:num)', 'Cart::remove/$1');
    $routes->delete('cart', 'Cart::clear');

    // Favorit (toggle berdasarkan id UMKM)
    $routes->get('favorites', 'Favorites::index');
    $routes->post('favorites/(:num)', 'Favorites::toggle/$1');

    // Pesanan
    $routes->get('orders', 'Orders::index');
    $routes->post('orders', 'Orders::create');
    $routes->get('orders/(:segment)', 'Orders::show/$1');
    $routes->post('orders/(:segment)/cancel', 'Orders::cancel/$1');

    // Alamat
    $routes->get('addresses', 'Addresses::index');
    $routes->post('addresses', 'Addresses::create');
    $routes->put('addresses/(:num)', 'Addresses::update/$1');
    $routes->delete('addresses/(:num)', 'Addresses::delete/$1');

    // Notifikasi
    $routes->get('notifications', 'Notifications::index');
    $routes->post('notifications/read', 'Notifications::markRead');
});

// 6c. API seller (role: seller)
$routes->group('api/v1/seller', [
    'namespace' => 'App\Controllers\Api\V1\Seller',
    'filter'    => 'role:seller',
], static function ($routes) {
    $routes->get('dashboard/summary', 'Dashboard::summary');

    $routes->get('products', 'Products::index');
    $routes->post('products', 'Products::create');
    $routes->get('products/(:num)', 'Products::show/$1');
    $routes->put('products/(:num)', 'Products::update/$1');
    $routes->delete('products/(:num)', 'Products::delete/$1');
    $routes->patch('products/(:num)/availability', 'Products::availability/$1');

    $routes->get('orders', 'Orders::index');
    $routes->get('orders/(:segment)', 'Orders::show/$1');
    $routes->patch('orders/(:segment)/status', 'Orders::updateStatus/$1');

    $routes->get('store', 'Store::show');
    $routes->put('store', 'Store::update');
    $routes->get('store/hours', 'Store::hours');
    $routes->put('store/hours', 'Store::saveHours');
    $routes->patch('store/open', 'Store::toggleOpen');

    // Gerobak
    $routes->post('location', 'Location::update');
    $routes->get('location/history', 'Location::history');

    $routes->get('reports/sales', 'Reports::sales');
    $routes->get('earnings', 'Earnings::index');
});

// 6d. API admin (role: admin)
$routes->group('api/v1/admin', [
    'namespace' => 'App\Controllers\Api\V1\Admin',
    'filter'    => 'role:admin',
], static function ($routes) {
    $routes->get('stats', 'Dashboard::stats');

    $routes->get('merchants', 'Merchants::index');
    $routes->get('merchants/(:num)', 'Merchants::show/$1');
    $routes->patch('merchants/(:num)/status', 'Merchants::updateStatus/$1');
    $routes->patch('merchants/(:num)/featured', 'Merchants::featured/$1');

    $routes->get('users', 'Users::index');
    $routes->patch('users/(:num)/status', 'Users::updateStatus/$1');

    $routes->get('orders', 'Orders::index');
    $routes->get('payments', 'Payments::index');

    $routes->get('categories', 'Categories::index');
    $routes->post('categories', 'Categories::create');
    $routes->put('categories/(:num)', 'Categories::update/$1');
    $routes->delete('categories/(:num)', 'Categories::delete/$1');
});