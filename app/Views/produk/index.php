<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
$base     = site_url('produk');
$filtered = $f['q'] !== '' || $f['tipe'] !== '' || $f['provinsi'] !== '' || $f['kecamatan'] !== '' || $f['kategori'] !== '' || $f['min'] !== '' || $f['max'] !== '' || $f['urut'] !== '';
$submit   = 'onchange="this.form.submit()"';
$imgUrl   = static fn (string $p): string => preg_match('#^https?://#', $p) ? $p : base_url($p);
?>

<section class="lh">
    <div class="w">
        <span class="live"><i></i>Semua produk</span>
        <h1 class="rise">Produk dari UMKM &amp; Gerobak</h1>
        <p class="lead rise" style="--i:1">Satu tempat untuk menemukan makanan, minuman, dan produk lokal di sekitarmu.
        </p>

        <form action="<?= $base ?>" method="get" role="search">
            <div class="sb big rise" style="--i:2">
                <i class="bi bi-search ic" style="font-size:1.25rem"></i>
                <input name="q" type="search" value="<?= esc($f['q'], 'attr') ?>" autocomplete="off"
                    placeholder="Cari produk atau nama usaha..." aria-label="Cari produk">
                <button class="btn" type="submit">Cari</button>
            </div>

            <div class="lfilters">
                <select name="tipe" aria-label="Jenis penjual" <?= $submit ?>>
                    <option value="">UMKM &amp; Gerobak</option>
                    <option value="toko" <?= $f['tipe'] === 'toko' ? 'selected' : '' ?>>UMKM saja</option>
                    <option value="gerobak" <?= $f['tipe'] === 'gerobak' ? 'selected' : '' ?>>Gerobak saja</option>
                </select>

                <select name="provinsi" aria-label="Provinsi" <?= $submit ?>>
                    <option value="">Semua provinsi</option>
                    <?php foreach ($provOptions as $k): ?>
                    <option value="<?= esc($k, 'attr') ?>" <?= $f['provinsi'] === $k ? 'selected' : '' ?>><?= esc($k) ?>
                    </option>
                    <?php endforeach ?>
                </select>

                <select name="kecamatan" aria-label="Kecamatan" <?= $submit ?>>
                    <option value="">Semua kecamatan</option>
                    <?php foreach ($kecOptions as $k): ?>
                    <option value="<?= esc($k, 'attr') ?>" <?= $f['kecamatan'] === $k ? 'selected' : '' ?>>
                        <?= esc($k) ?></option>
                    <?php endforeach ?>
                </select>

                <select name="kategori" aria-label="Kategori" <?= $submit ?>>
                    <option value="">Semua kategori</option>
                    <?php foreach ($katOptions as $c): ?>
                    <option value="<?= esc($c['slug'], 'attr') ?>"
                        <?= $f['kategori'] === $c['slug'] ? 'selected' : '' ?>>
                        <?= esc(trim(($c['icon'] ?? '') . ' ' . $c['name'])) ?></option>
                    <?php endforeach ?>
                </select>

                <input type="number" name="min" min="0" step="1000" value="<?= esc($f['min'], 'attr') ?>"
                    placeholder="Harga min" aria-label="Harga minimum">
                <input type="number" name="max" min="0" step="1000" value="<?= esc($f['max'], 'attr') ?>"
                    placeholder="Harga maks" aria-label="Harga maksimum">
                <button type="submit" class="btn sm ghost">Terapkan</button>

                <select name="urut" aria-label="Urutkan" <?= $submit ?>>
                    <option value="" <?= $f['urut'] === '' ? 'selected' : '' ?>>Terbaru</option>
                    <option value="terlaris" <?= $f['urut'] === 'terlaris' ? 'selected' : '' ?>>Terlaris</option>
                    <option value="termurah" <?= $f['urut'] === 'termurah' ? 'selected' : '' ?>>Harga terendah</option>
                    <option value="termahal" <?= $f['urut'] === 'termahal' ? 'selected' : '' ?>>Harga tertinggi</option>
                    <option value="nama" <?= $f['urut'] === 'nama' ? 'selected' : '' ?>>Nama A–Z</option>
                </select>

                <?php if ($filtered): ?><a class="more" href="<?= $base ?>">Reset</a><?php endif ?>
            </div>
        </form>
    </div>
</section>

<section>
    <div class="w">
        <p class="meta rcount"><b><?= (int) $total ?></b> produk ditemukan</p>

        <?php if (empty($items)): ?>
        <div class="empty">
            <?= $filtered
                ? 'Tidak ada produk untuk filter ini. <a href="' . $base . '">Reset filter</a>.'
                : 'Belum ada produk yang tampil.' ?>
        </div>
        <?php else: ?>
        <div class="grid">
            <?php foreach ($items as $p): ?>
            <?= view('partials/product_item', ['p' => $p]) ?>
            <?php endforeach ?>
        </div>
        <?= $pagerHtml ?>
        <?php endif ?>
    </div>
</section>
<?= $this->endSection() ?>