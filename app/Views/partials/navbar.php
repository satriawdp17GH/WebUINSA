<?php
/**
 * Navbar sticky. Berubah sesuai login/role.
 * Sesuaikan session()->get('user') dengan implementasi Auth-mu,
 * contoh isi: ['id' => 7, 'name' => 'Andra', 'role' => 'seller'].
 */
$user = session()->get('user');
$role = $user['role'] ?? null;
$seg  = service('request')->getUri()->getSegment(1);

$menu = [
    ['Beranda', '', ''],
    ['Jelajahi UMKM', 'jelajahi', 'jelajahi'],
    ['Produk', 'produk', 'produk'],
    ['Gerobak', 'gerobak', 'gerobak'],
    ['Pesanan', 'pesanan', 'pesanan'],
];
$roleLabel = ['buyer' => 'Pembeli', 'seller' => 'Penjual', 'admin' => 'Admin', 'courier' => 'Kurir'];
?>
<header class="hdr"
        x-data="{ scrolled: false, search: false, acc: false, bump: false }"
        :class="{ 'is-scrolled': scrolled }"
        @scroll.window.passive="scrolled = window.scrollY > 8"
        @keydown.escape.window="search = false; acc = false"
        x-init="$watch('$store.cart.count', () => { bump = true; setTimeout(() => bump = false, 450) })">
    <div class="w nav">
        <a class="logo" href="<?= site_url('/') ?>" aria-label="ARUNA — Beranda">
            <?= aruna_logo(32) ?><span>ARUNA</span>
        </a>

        <nav class="menu" aria-label="Menu utama">
            <?php foreach ($menu as [$label, $href, $key]): ?>
                <a href="<?= site_url($href) ?>" class="<?= $seg === $key ? 'on' : '' ?>"
                   <?= $seg === $key ? 'aria-current="page"' : '' ?>><?= esc($label) ?></a>
            <?php endforeach ?>
        </nav>

        <div class="act">
            <button type="button" class="ib" aria-label="Cari"
                    @click="search = !search; $nextTick(() => search && $refs.q.focus())"><?= aruna_icon('search') ?></button>

            <a class="ib" href="<?= site_url('favorit') ?>" aria-label="Favorit">
                <?= aruna_icon('heart') ?>
                <span class="badge" x-show="$store.fav.count" x-text="$store.fav.count" x-cloak></span>
            </a>

            <button type="button" class="ib" aria-label="Buka keranjang" @click="$store.cart.open = true">
                <?= aruna_icon('bag') ?>
                <span class="badge" :class="{ bump }" x-show="$store.cart.count" x-text="$store.cart.count" x-cloak></span>
            </button>

            <?php if ($user): ?>
                <div class="acc" @click.outside="acc = false">
                    <button type="button" class="avatar" @click="acc = !acc" :aria-expanded="acc" aria-label="Menu akun">
                        <?= esc(mb_strtoupper(mb_substr($user['name'], 0, 1))) ?>
                    </button>
                    <div class="pop pop-r" x-show="acc" x-transition.origin.top.right x-cloak>
                        <div class="who">
                            <b><?= esc($user['name']) ?></b>
                            <small><?= esc($roleLabel[$role] ?? 'Pengguna') ?></small>
                        </div>
                        <?php if ($role === 'seller'): ?>
                            <a href="<?= site_url('seller') ?>">Dashboard Toko</a>
                            <a href="<?= site_url('seller/pesanan') ?>">Pesanan Masuk</a>
                        <?php elseif ($role === 'admin'): ?>
                            <a href="<?= site_url('admin') ?>">Dashboard Admin</a>
                            <a href="<?= site_url('admin/umkm') ?>">Verifikasi UMKM</a>
                        <?php endif ?>
                        <a href="<?= site_url('akun') ?>">Akun Saya</a>
                        <a href="<?= site_url('pesanan') ?>">Pesanan Saya</a>
                        <a href="<?= site_url('favorit') ?>">Favorit</a>
                        <a class="out" href="<?= site_url('keluar') ?>">Keluar</a>
                    </div>
                </div>
            <?php else: ?>
                <a class="btn ghost sm only-d" href="<?= site_url('masuk') ?>">Masuk</a>
                <a class="btn sm only-d" href="<?= site_url('daftar') ?>">Daftar</a>
                <a class="ib only-m" href="<?= site_url('masuk') ?>" aria-label="Masuk"><?= aruna_icon('user') ?></a>
            <?php endif ?>
        </div>
    </div>

    <!-- Panel pencarian -->
    <div class="spanel" x-show="search" x-transition.opacity x-cloak @click.outside="search = false">
        <div class="w">
            <form action="<?= site_url('cari') ?>" method="get" role="search" class="sb">
                <?= aruna_icon('search', 20) ?>
                <input x-ref="q" name="q" type="search" placeholder="Cari produk, UMKM, atau makanan..." autocomplete="off" aria-label="Cari">
                <button class="btn" type="submit">Cari</button>
            </form>
            <p class="chips">Populer:
                <?php foreach (['bakso', 'nasi ayam', 'kopi susu', 'batik', 'sambal'] as $k): ?>
                    <a href="<?= site_url('cari') . '?q=' . urlencode($k) ?>"><?= esc($k) ?></a>
                <?php endforeach ?>
            </p>
        </div>
    </div>
</header>
