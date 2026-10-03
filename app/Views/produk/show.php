<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
/**
 * Detail produk + informasi penjual (toko atau gerobak).
 * Butuh: $p (products.* + m_* dari merchants), $others, $wa, $waAsk
 */
$isG     = $p['m_type'] === 'gerobak';
$sellerUrl = site_url(($isG ? 'gerobak' : 'umkm') . '/' . $p['m_slug']);
$imgUrl  = static fn (string $x): string => preg_match('#^https?://#', $x) ? $x : base_url($x);
$area    = implode(', ', array_filter([$p['m_district'], $p['m_city'], $p['m_province']]));
$maps    = (! empty($p['m_latitude']) && ! empty($p['m_longitude'])) ? 'https://www.google.com/maps?q=' . $p['m_latitude'] . ',' . $p['m_longitude'] : '';
$ago     = static function (?string $t): string {
    if (! $t || ($ts = strtotime($t)) === false) {
        return '';
    }
    $d = max(0, time() - $ts);
    if ($d < 90)    return 'baru saja';
    if ($d < 3600)  return floor($d / 60) . ' menit lalu';
    if ($d < 86400) return floor($d / 3600) . ' jam lalu';
    return floor($d / 86400) . ' hari lalu';
};
$ready = (int) $p['is_available'] === 1 && ($p['stock'] === null || (int) $p['stock'] > 0);
?>

<section class="dt">
    <div class="w">
        <nav class="crumb" aria-label="Breadcrumb">
            <a href="<?= site_url('/') ?>">Beranda</a> <i class="bi bi-chevron-right"></i>
            <a href="<?= site_url('produk') ?>">Produk</a> <i class="bi bi-chevron-right"></i>
            <span><?= esc($p['name']) ?></span>
        </nav>

        <div class="dt-grid">
            <div class="dt-media tone-<?= ($p['id'] % 6) + 1 ?> <?= $ready ? '' : 'is-closed' ?>">
                <?php if (! empty($p['photo'])): ?>
                <img src="<?= esc($imgUrl($p['photo']), 'attr') ?>" alt="<?= esc($p['name'], 'attr') ?>">
                <?php else: ?>
                <span
                    class="emo"><?= ! empty($p['category_icon']) ? esc($p['category_icon']) : '<i class="bi bi-bag-fill"></i>' ?></span>
                <?php endif ?>
            </div>

            <div class="dt-info">
                <div class="dt-tags">
                    <?php if (! empty($p['category_name'])): ?><span
                        class="pill"><?= esc($p['category_name']) ?></span><?php endif ?>
                    <span class="pill"><?= $isG ? 'Gerobak' : 'UMKM' ?></span>
                </div>

                <h1><?= esc($p['name']) ?></h1>

                <div class="dt-stats">
                    <?php if ((int) $p['rating_count'] > 0): ?>
                    <span class="rt"><i class="bi bi-star-fill ic"></i>
                        <?= number_format((float) $p['rating_avg'], 1) ?> <span
                            class="meta">(<?= (int) $p['rating_count'] ?> ulasan)</span></span>
                    <?php endif ?>
                    <?php if ((int) $p['sold_count'] > 0): ?><span><i class="bi bi-bag-check"></i>
                        <?= number_format((int) $p['sold_count'], 0, ',', '.') ?> terjual</span><?php endif ?>
                    <span class="<?= $ready ? 'ok' : 'bad' ?>"><i
                            class="bi <?= $ready ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?>"></i>
                        <?= $ready ? ($p['stock'] === null ? 'Tersedia' : 'Stok ' . (int) $p['stock']) : 'Tidak tersedia' ?></span>
                </div>

                <div class="dt-price">Rp<?= number_format((int) $p['price'], 0, ',', '.') ?></div>

                <?php if (! empty($p['description'])): ?>
                <p class="dt-desc"><?= nl2br(esc($p['description'])) ?></p>
                <?php endif ?>

                <div class="dt-actions">
                    <?php if ($ready && $wa !== ''): ?>
                    <a class="btn" href="<?= esc($wa, 'attr') ?>" target="_blank" rel="noopener"><i
                            class="bi bi-whatsapp"></i> Pesan via WhatsApp</a>
                    <?php endif ?>
                    <a class="btn ghost" href="<?= $sellerUrl ?>">Lihat <?= $isG ? 'gerobak' : 'toko' ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="tight">
    <div class="w">
        <div class="box">
            <h3>Informasi penjual</h3>
            <div class="seller">
                <div class="av tone-<?= ($p['merchant_id'] % 6) + 1 ?>">
                    <?php if (! empty($p['m_photo'])): ?>
                    <img src="<?= esc($imgUrl($p['m_photo']), 'attr') ?>" alt="">
                    <?php else: ?>
                    <?= ! empty($p['m_category_icon']) ? esc($p['m_category_icon']) : '<i class="bi ' . ($isG ? 'bi-bicycle' : 'bi-shop') . '"></i>' ?>
                    <?php endif ?>
                </div>
                <div class="seller-info">
                    <a class="seller-name" href="<?= $sellerUrl ?>"><?= esc($p['m_name']) ?></a>
                    <div class="dt-stats">
                        <span class="pill"><?= $isG ? 'Gerobak' : 'UMKM' ?></span>
                        <span class="<?= $p['m_is_open'] ? 'ok' : 'bad' ?>"><i class="bi bi-circle-fill"
                                style="font-size:.5rem"></i>
                            <?= $p['m_is_open'] ? ($isG ? 'Sedang jualan' : 'Buka') : 'Tutup' ?></span>
                        <?php if ((int) $p['m_rating_count'] > 0): ?>
                        <span class="rt"><i class="bi bi-star-fill ic"></i>
                            <?= number_format((float) $p['m_rating_avg'], 1) ?></span>
                        <?php endif ?>
                        <span><i class="bi bi-clock"></i> siap ±<?= (int) $p['m_prep_minutes'] ?> menit</span>
                    </div>
                    <?php if ($isG && ! empty($p['m_location_label'])): ?>
                    <p class="where"><i class="bi bi-geo-alt-fill"></i> <?= esc($p['m_location_label']) ?>
                        <?php if (! empty($p['m_location_updated_at'])): ?><span class="meta">• diperbarui
                            <?= $ago($p['m_location_updated_at']) ?></span><?php endif ?></p>
                    <?php elseif ($area !== ''): ?>
                    <p class="where"><i class="bi bi-geo-alt-fill"></i> <?= esc($area) ?></p>
                    <?php endif ?>
                </div>
                <div class="dt-actions seller-act">
                    <?php if ($maps !== ''): ?><a class="btn ghost sm" href="<?= esc($maps, 'attr') ?>" target="_blank"
                        rel="noopener">Peta</a><?php endif ?>
                    <?php if ($waAsk !== ''): ?><a class="btn ghost sm" href="<?= esc($waAsk, 'attr') ?>"
                        target="_blank" rel="noopener">Hubungi</a><?php endif ?>
                    <a class="btn navy sm" href="<?= $sellerUrl ?>">Kunjungi</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (! empty($others)): ?>
<section>
    <div class="w">
        <div class="sh">
            <div>
                <h2>Produk lain dari <?= esc($p['m_name']) ?></h2>
            </div>
            <a class="more" href="<?= $sellerUrl ?>#produk">Lihat semua <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="grid">
            <?php foreach ($others as $o): ?>
            <?= view('partials/product_item', ['p' => $o]) ?>
            <?php endforeach ?>
        </div>
    </div>
</section>
<?php endif ?>
<?= $this->endSection() ?>