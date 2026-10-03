<?php
/**
 * Dipakai jelajahi/index.php & gerobak/index.php
 * Butuh: $type ('toko'|'gerobak'), $items, $pagerHtml, $total,
 *        $provOptions, $kecOptions, $katOptions, $f
 */
$isG      = $type === 'gerobak';
$base     = site_url($isG ? 'gerobak' : 'jelajahi');
$filtered = $f['q'] !== '' || $f['provinsi'] !== '' || $f['kecamatan'] !== '' || $f['kategori'] !== '' || $f['buka'] !== '';
$submit   = 'onchange="this.form.submit()"';
$imgUrl   = static fn (string $p): string => preg_match('#^https?://#', $p) ? $p : base_url($p);
?>

<section class="lh">
    <div class="w">
        <span class="live"><i></i><?= $isG ? 'Fitur khas ARUNA' : 'UMKM lokal' ?></span>
        <h1 class="rise"><?= $isG ? 'Gerobak yang Sedang Jualan' : 'Jelajahi UMKM' ?></h1>
        <p class="lead rise" style="--i:1">
            <?= $isG
                ? 'Cari pedagang gerobak yang sedang berjualan di sekitar lokasimu.'
                : 'Temukan usaha lokal yang siap melayani pesananmu.' ?>
        </p>

        <form action="<?= $base ?>" method="get" role="search">
            <div class="sb big rise" style="--i:2">
                <i class="bi bi-search ic" style="font-size:1.25rem"></i>
                <input name="q" type="search" value="<?= esc($f['q'], 'attr') ?>" autocomplete="off"
                    placeholder="<?= $isG ? 'Cari gerobak, menu, atau lokasi...' : 'Cari nama usaha...' ?>"
                    aria-label="Cari">
                <button class="btn" type="submit">Cari</button>
            </div>

            <div class="lfilters">
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

                <?php if ($isG): ?>
                <label class="chk">
                    <input type="checkbox" name="buka" value="1" <?= $f['buka'] === '1' ? 'checked' : '' ?>
                        <?= $submit ?>>
                    Sedang jualan
                </label>
                <?php endif ?>

                <select name="urut" aria-label="Urutkan" <?= $submit ?>>
                    <option value="terbaru" <?= $f['urut'] === 'terbaru' ? 'selected' : '' ?>>Terbaru</option>
                    <option value="terlaris" <?= $f['urut'] === 'terlaris' ? 'selected' : '' ?>>Terlaris</option>
                    <option value="nama" <?= $f['urut'] === 'nama' ? 'selected' : '' ?>>Nama A–Z</option>
                </select>

                <?php if ($filtered): ?><a class="more" href="<?= $base ?>">Reset</a><?php endif ?>
            </div>
        </form>
    </div>
</section>

<section>
    <div class="w">
        <p class="meta rcount"><b><?= (int) $total ?></b> <?= $isG ? 'gerobak' : 'UMKM' ?> ditemukan</p>

        <?php if (empty($items)): ?>
        <div class="empty">
            <?= $filtered
                ? 'Tidak ada hasil untuk filter ini. <a href="' . $base . '">Reset filter</a>.'
                : 'Belum ada ' . ($isG ? 'gerobak' : 'UMKM') . ' yang tampil. <a href="' . site_url('gabung/' . ($isG ? 'gerobak' : 'umkm')) . '">Daftarkan ' . ($isG ? 'gerobakmu' : 'usahamu') . '</a>.' ?>
        </div>
        <?php else: ?>
        <div class="grid g3 list-m">
            <?php foreach ($items as $m):
                $closed = $isG && ! $m['is_open'];
                $digits = preg_replace('/\D+/', '', (string) ($m['phone'] ?? ''));
                if (str_starts_with($digits, '0')) {
                    $digits = '62' . substr($digits, 1);
                }
                $wa   = $digits !== '' ? 'https://wa.me/' . $digits . '?text=' . rawurlencode('Halo ' . $m['name'] . ', saya lihat usaha Anda di ARUNA.') : '';
                $area = implode(', ', array_filter([$m['district'], $m['city']]));
            ?>
            <article class="card <?= $closed ? 'is-closed' : '' ?>">
                <div class="ph tone-<?= ($m['id'] % 6) + 1 ?>">
                    <?php if (! empty($m['photo'])): ?>
                    <img src="<?= esc($imgUrl($m['photo']), 'attr') ?>" alt="<?= esc($m['name'], 'attr') ?>"
                        loading="lazy">
                    <?php else: ?>
                    <span
                        class="emo"><?= ! empty($m['category_icon']) ? esc($m['category_icon']) : '<i class="bi ' . ($isG ? 'bi-bicycle' : 'bi-shop') . '"></i>' ?></span>
                    <?php endif ?>
                    <?php if ($isG): ?>
                    <span
                        class="st <?= $m['is_open'] ? 'on' : 'off' ?>"><i></i><?= $m['is_open'] ? 'Sedang jualan' : 'Tutup' ?></span>
                    <?php endif ?>
                    <?php if (! empty($m['category_name'])): ?><span
                        class="tag"><?= esc($m['category_name']) ?></span><?php endif ?>
                </div>
                <div class="cb">
                    <h3><a class="stretch"
                            href="<?= site_url(($isG ? 'gerobak' : 'umkm') . '/' . $m['slug']) ?>"><?= esc($m['name']) ?></a>
                    </h3>
                    <?php if ($isG && ! empty($m['location_label'])): ?>
                    <p class="where"><i class="bi bi-geo-alt-fill"></i> <?= esc($m['location_label']) ?></p>
                    <?php endif ?>
                    <p class="meta"><?= $area !== '' ? esc($area) : esc($m['address'] ?? '') ?></p>
                    <div class="row">
                        <?php if ((int) $m['rating_count'] > 0): ?>
                        <span class="rt"><i class="bi bi-star-fill ic"></i>
                            <?= number_format((float) $m['rating_avg'], 1) ?> <span
                                class="meta">(<?= (int) $m['rating_count'] ?>)</span></span>
                        <?php else: ?><span class="meta">Belum ada ulasan</span><?php endif ?>
                        <?php if ($wa !== ''): ?>
                        <a class="btn sm navy" style="position:relative;z-index:2" href="<?= esc($wa, 'attr') ?>"
                            target="_blank" rel="noopener">Hubungi</a>
                        <?php endif ?>
                    </div>
                </div>
            </article>
            <?php endforeach ?>
        </div>
        <?= $pagerHtml ?>
        <?php endif ?>
    </div>
</section>