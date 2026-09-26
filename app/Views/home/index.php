<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- ================= HERO ================= -->
<section class="hero" id="hero">
    <div class="w hg">
        <div class="hcopy">
            <h1 class="rise" style="--i:0">Temukan UMKM Lokal di Sekitarmu</h1>
            <p class="lead rise" style="--i:1">Belanja produk lokal, pesan dari UMKM favorit, atau temukan gerobak yang
                sedang jualan di dekatmu.</p>

            <form action="<?= site_url('cari') ?>" method="get" role="search" class="sb big rise" style="--i:2"
                x-data="{ f: false }" @focusin="f = true" @click.outside="f = false">
                <?= aruna_icon('search', 22) ?>
                <input name="q" type="search" placeholder="Cari produk, UMKM, atau makanan..." autocomplete="off"
                    aria-label="Cari produk, UMKM, atau makanan">
                <button class="btn" type="submit">Cari<span class="only-d"> Sekarang</span></button>
                <div class="sug" x-show="f" x-transition.opacity x-cloak>
                    <span>Pencarian populer</span>
                    <?php foreach (['Bakso Pak Darto', 'Nasi ayam', 'Es kopi susu', 'Batik tulis', 'Sambal bawang'] as $k): ?>
                    <a href="<?= site_url('cari') . '?q=' . urlencode($k) ?>"><?= aruna_icon('search', 16) ?>
                        <?= esc($k) ?></a>
                    <?php endforeach ?>
                </div>
            </form>

            <div class="loc rise" style="--i:3" x-data="{ o: false }" @click.outside="o = false"
                @keydown.escape="o = false">
                <span class="dot" aria-hidden="true"></span>
                <span>📍 Menampilkan UMKM di sekitar kamu</span>
                <button type="button" class="locbtn" @click="o = !o" :aria-expanded="o">
                    <?= esc($activeName ?? 'Semua kecamatan') ?> <?= aruna_icon('chevron', 16) ?>
                </button>
                <div class="pop pop-l" x-show="o" x-transition.origin.top.left x-cloak>
                    <a href="<?= site_url('/') ?>" class="<?= $activeSlug === '' ? 'cur' : '' ?>">Semua kecamatan</a>
                    <?php foreach ($districts as $slug => $name): ?>
                    <a href="?kecamatan=<?= esc($slug, 'attr') ?>"
                        class="<?= $activeSlug === $slug ? 'cur' : '' ?>"><?= esc($name) ?></a>
                    <?php endforeach ?>
                </div>
            </div>
        </div>

        <div class="col" id="collage" aria-hidden="true">
            <div class="cgrid">
                <?php foreach ($hero as $n => $t): $k = $n + 1; ?>
                <div class="tile t<?= $k ?> tone-<?= $k ?>" style="--i:<?= $n ?>;--p:<?= 6 + $n * 3 ?>">
                    <?= aruna_media($t['photo'], $t['emoji'], $t['label']) ?>
                    <?php if ($t['label']): ?><small><?= esc($t['label']) ?></small><?php endif ?>
                </div>
                <?php endforeach ?>
            </div>
            <?php if (! empty($gerobak[0])): $lc = $gerobak[0]; ?>
            <div class="live-chip">
                <span class="live"><i></i>Sedang Jualan</span>
                <b><?= esc($lc['name']) ?></b>
                <small><?= esc($lc['location']) ?> • <?= fmt_km($lc['distance']) ?></small>
            </div>
            <?php endif ?>
        </div>
    </div>
</section>

<!-- ================= KATEGORI ================= -->
<section class="sec-cats">
    <div class="w">
        <div class="cats" role="list">
            <?php foreach ($categories as $n => [$emo, $label, $slug]): ?>
            <a class="cat" role="listitem" href="<?= site_url('kategori/' . $slug) ?>" data-reveal
                style="--i:<?= $n ?>">
                <span class="e" aria-hidden="true"><?= $emo ?></span><?= esc($label) ?>
            </a>
            <?php endforeach ?>
            <a class="cat" role="listitem" href="<?= site_url('jelajahi') ?>" data-reveal style="--i:6">
                <span class="e" aria-hidden="true"><?= aruna_icon('arrow', 28) ?></span>Lainnya
            </a>
        </div>
    </div>
</section>

<!-- ================= UMKM DI SEKITARMU ================= -->
<section id="sekitar">
    <div class="w">
        <div class="sh">
            <div>
                <h2>UMKM di Sekitarmu</h2>
                <p class="sub">Temukan usaha lokal yang sedang buka dan siap melayani pesananmu.</p>
            </div>
            <a class="more" href="<?= site_url('jelajahi') ?>">Lihat semua <?= aruna_icon('arrow', 18) ?></a>
        </div>
        <?php if (empty($umkm)): ?>
        <div class="empty">Belum ada UMKM di kecamatan ini. Coba pilih kecamatan lain atau <a
                href="<?= site_url('/') ?>">tampilkan semua</a>.</div>
        <?php else: ?>
        <div class="grid list-m">
            <?php foreach ($umkm as $i => $m): ?>
            <?= $this->setVar('m', $m)->setVar('i', $i)->include('partials/umkm_card') ?>
            <?php endforeach ?>
        </div>
        <?php endif ?>
    </div>
</section>

<!-- ================= GEROBAK ================= -->
<section id="gerobak">
    <div class="w">
        <div class="gero">
            <div class="gero-head">
                <div>
                    <span class="live"><i></i>Fitur khas ARUNA</span>
                    <h2>Gerobak yang Sedang Jualan</h2>
                    <p class="sub">Cari pedagang gerobak yang sedang berjualan di sekitar lokasimu.</p>
                </div>
                <div class="route" aria-hidden="true">
                    <svg viewBox="0 0 320 70" width="320" height="70">
                        <path class="rp" d="M4 52 C 60 8, 110 8, 150 36 S 250 70, 316 18" />
                        <circle cx="4" cy="52" r="5" />
                        <circle cx="150" cy="36" r="5" />
                        <circle cx="316" cy="18" r="5" />
                    </svg>
                    <span class="rider">🛺</span>
                </div>
            </div>
            <?php if (empty($gerobak)): ?>
            <div class="empty">Belum ada gerobak yang sedang jualan di kecamatan ini.</div>
            <?php else: ?>
            <div class="grid g3 snap-m">
                <?php foreach ($gerobak as $i => $g): ?>
                <?= $this->setVar('g', $g)->setVar('i', $i)->include('partials/gerobak_card') ?>
                <?php endforeach ?>
            </div>
            <?php endif ?>
        </div>
    </div>
</section>

<!-- ================= PRODUK POPULER ================= -->
<section id="populer">
    <div class="w">
        <div class="sh">
            <div>
                <h2>Paling Banyak Dipesan</h2>
                <p class="sub">Menu dan produk favorit pembeli di sekitarmu.</p>
            </div>
            <a class="more" href="<?= site_url('produk') ?>">Lihat semua <?= aruna_icon('arrow', 18) ?></a>
        </div>
        <div class="grid">
            <?php foreach ($products as $i => $p): ?>
            <?= $this->setVar('p', $p)->setVar('i', $i)->include('partials/product_card') ?>
            <?php endforeach ?>
        </div>
    </div>
</section>

<!-- ================= UMKM PILIHAN ================= -->
<section>
    <div class="w" x-data>
        <div class="sh">
            <div>
                <h2>UMKM Pilihan ARUNA</h2>
                <p class="sub">Usaha lokal yang sedang banyak dikunjungi pembeli.</p>
            </div>
            <div class="arrows only-d">
                <button type="button" class="hbtn" aria-label="Geser ke kiri"
                    @click="$refs.row.scrollBy({ left: -360, behavior: 'smooth' })"><?= aruna_icon('left', 20) ?></button>
                <button type="button" class="hbtn" aria-label="Geser ke kanan"
                    @click="$refs.row.scrollBy({ left: 360, behavior: 'smooth' })"><?= aruna_icon('right', 20) ?></button>
            </div>
        </div>
        <div class="hs" x-ref="row" tabindex="0" aria-label="Daftar UMKM pilihan">
            <?php foreach ($featured as $f): ?>
            <?= $this->setVar('f', $f)->include('partials/featured_card') ?>
            <?php endforeach ?>
        </div>
    </div>
</section>

<!-- ================= CARA KERJA ================= -->
<section id="cara">
    <div class="w">
        <div class="sh">
            <div>
                <h2>Cara Kerja</h2>
                <p class="sub">Empat langkah dari mencari sampai pesanan sampai di depan pintu.</p>
            </div>
        </div>
        <div class="steps" data-in>
            <?php
            $steps = [
                ['01', 'search', 'Cari',   'Temukan produk atau UMKM di sekitar kamu.'],
                ['02', 'bag',    'Pesan',  'Pilih produk dan lakukan pemesanan.'],
                ['03', 'card',   'Bayar',  'Bayar secara digital dengan aman.'],
                ['04', 'truck',  'Terima', 'Pesanan disiapkan UMKM dan diantar kurir.'],
            ];
            foreach ($steps as $n => [$no, $ic, $t, $d]): ?>
            <div class="stp" data-reveal style="--i:<?= $n ?>">
                <span class="n"><?= $no ?></span>
                <div class="icb"><?= aruna_icon($ic, 28) ?></div>
                <h3><?= $t ?></h3>
                <p><?= $d ?></p>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</section>

<!-- ================= CTA PEMILIK UMKM ================= -->
<section class="tight">
    <div class="w">
        <div class="cta" data-in>
            <div>
                <h2>Usahamu Bisa Tumbuh Lebih Jauh Bersama ARUNA</h2>
                <p>Kelola produk, pesanan, pembayaran, dan penjualan dalam satu platform.</p>
                <a class="btn light" href="<?= site_url('gabung/umkm') ?>">Gabung Sebagai UMKM
                    <?= aruna_icon('arrow', 18) ?></a>
            </div>
            <div class="dash" aria-label="Contoh dashboard penjual">
                <div class="dtop"><b>Dashboard Toko</b><span class="live"><i></i>Buka</span></div>
                <div class="kp">
                    <div><small>Penjualan hari ini</small><b data-count="1250000" data-prefix="Rp">Rp1.250.000</b></div>
                    <div><small>Pesanan baru</small><b data-count="18">18</b></div>
                    <div><small>Produk terlaris</small><b>Nasi Ayam</b></div>
                    <div><small>Pendapatan bulan ini</small><b data-count="24800000" data-prefix="Rp">Rp24.800.000</b>
                    </div>
                </div>
                <div class="bars">
                    <?php foreach ([35, 52, 44, 70, 60, 88, 100] as $n => $h): ?><i
                        style="--h:<?= $h ?>%;--i:<?= $n ?>"></i><?php endforeach ?>
                </div>
                <div class="notif"><span>🔔</span>
                    <div><b>Pesanan baru #A-2041</b><small>2 Nasi Ayam • Rp38.000</small></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= CTA GEROBAK ================= -->
<section class="tight">
    <div class="w">
        <div class="cta alt">
            <div>
                <h2>Jualan di Mana Saja, Tetap Ditemukan Pelanggan</h2>
                <p>Perbarui lokasi jualanmu dan biarkan pelanggan menemukanmu saat kamu sedang berjualan.</p>
                <a class="btn navy" href="<?= site_url('gabung/gerobak') ?>">Daftar sebagai UMKM Gerobak
                    <?= aruna_icon('arrow', 18) ?></a>
            </div>
            <!-- Demo interaktif: coba pindahkan lokasi gerobak -->
            <div class="mapdemo"
                x-data="{ on: true, i: 0, spots: [ { x: 28, y: 64, t: 'Jl. Raya Darmo' }, { x: 62, y: 32, t: 'Taman Bungkul' }, { x: 80, y: 70, t: 'Jl. Ngagel' } ] }">
                <div class="map">
                    <svg viewBox="0 0 400 260" preserveAspectRatio="none" aria-hidden="true">
                        <path d="M0 190 C100 150 160 210 260 150 S 360 90 400 110" />
                        <path d="M120 0 C 130 80 90 140 150 260" />
                        <path d="M0 70 L400 40" />
                        <path d="M300 0 C 280 90 330 170 310 260" />
                    </svg>
                    <span class="pin" :class="{ off: !on }" :style="`left:${spots[i].x}%;top:${spots[i].y}%`">
                        <i class="ripple"></i><i class="ripple r2"></i><em>🛺</em>
                    </span>
                </div>
                <div class="mrow">
                    <div><b x-text="spots[i].t"></b><small
                            x-text="on ? 'Lokasi diperbarui baru saja' : 'Tidak terlihat oleh pembeli'"></small></div>
                    <button type="button" class="btn sm" @click="i = (i + 1) % spots.length">Pindah lokasi</button>
                </div>
                <div class="mrow sw">
                    <span x-text="on ? 'Sedang jualan' : 'Istirahat'"></span>
                    <button type="button" class="swb" role="switch" :aria-checked="on" aria-label="Status jualan"
                        @click="on = !on"><i></i></button>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>