<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
/**
 * Detail UMKM (type 'toko') & gerobak.
 * Butuh: $m, $products, $hours, $reviews, $wa
 */
$isG     = $m['type'] === 'gerobak';
$listUrl = site_url($isG ? 'gerobak' : 'jelajahi');
$area    = implode(', ', array_filter([$m['district'], $m['city'], $m['province']]));
$imgUrl  = static fn (string $x): string => preg_match('#^https?://#', $x) ? $x : base_url($x);
$maps    = (! empty($m['latitude']) && ! empty($m['longitude'])) ? 'https://www.google.com/maps?q=' . $m['latitude'] . ',' . $m['longitude'] : '';
$days    = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'];
$today   = (int) date('N');
$hm      = static fn (?string $t): string => $t ? substr($t, 0, 5) : '';
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
$todayRow = null;
foreach ($hours as $h) {
    if ($h['dn'] === $today) { $todayRow = $h; }
}
?>

<section class="dt">
    <div class="w">
        <nav class="crumb" aria-label="Breadcrumb">
            <a href="<?= site_url('/') ?>">Beranda</a> <i class="bi bi-chevron-right"></i>
            <a href="<?= $listUrl ?>"><?= $isG ? 'Gerobak' : 'Jelajahi UMKM' ?></a> <i class="bi bi-chevron-right"></i>
            <span><?= esc($m['name']) ?></span>
        </nav>

        <div class="dt-grid">
            <div class="dt-media tone-<?= ($m['id'] % 6) + 1 ?> <?= $isG && ! $m['is_open'] ? 'is-closed' : '' ?>">
                <?php if (! empty($m['photo'])): ?>
                <img src="<?= esc($imgUrl($m['photo']), 'attr') ?>" alt="<?= esc($m['name'], 'attr') ?>">
                <?php else: ?>
                <span
                    class="emo"><?= ! empty($m['category_icon']) ? esc($m['category_icon']) : '<i class="bi ' . ($isG ? 'bi-bicycle' : 'bi-shop') . '"></i>' ?></span>
                <?php endif ?>
                <span
                    class="st <?= $m['is_open'] ? 'on' : 'off' ?>"><i></i><?= $m['is_open'] ? ($isG ? 'Sedang jualan' : 'Buka') : 'Tutup' ?></span>
            </div>

            <div class="dt-info">
                <div class="dt-tags">
                    <span class="pill"><?= $isG ? 'Gerobak' : 'UMKM' ?></span>
                    <?php if (! empty($m['category_name'])): ?>
                    <a class="pill"
                        href="<?= $isG ? $listUrl . '?kategori=' . urlencode($m['category_slug']) : site_url('kategori/' . $m['category_slug']) ?>"><?= esc($m['category_name']) ?></a>
                    <?php endif ?>
                </div>

                <h1><?= esc($m['name']) ?></h1>

                <div class="dt-stats">
                    <?php if ((int) $m['rating_count'] > 0): ?>
                    <span class="rt"><i class="bi bi-star-fill ic"></i>
                        <?= number_format((float) $m['rating_avg'], 1) ?> <span
                            class="meta">(<?= (int) $m['rating_count'] ?> ulasan)</span></span>
                    <?php else: ?>
                    <span class="meta">Belum ada ulasan</span>
                    <?php endif ?>
                    <?php if ((int) $m['sold_count'] > 0): ?><span><i class="bi bi-bag-check"></i>
                        <?= number_format((int) $m['sold_count'], 0, ',', '.') ?> terjual</span><?php endif ?>
                </div>

                <?php if (! empty($m['description'])): ?>
                <p class="dt-desc"><?= nl2br(esc($m['description'])) ?></p>
                <?php endif ?>

                <?php if ($isG && ! empty($m['location_label'])): ?>
                <div class="box dt-loc">
                    <p class="where"><i class="bi bi-geo-alt-fill"></i> <b><?= esc($m['location_label']) ?></b></p>
                    <?php if (! empty($m['location_updated_at'])): ?>
                    <p class="upd"><i class="bi bi-clock-history"></i> Lokasi diperbarui
                        <?= $ago($m['location_updated_at']) ?></p>
                    <?php endif ?>
                    <?php if ($maps !== ''): ?><a class="more" href="<?= esc($maps, 'attr') ?>" target="_blank"
                        rel="noopener">Buka di peta <i class="bi bi-arrow-up-right"></i></a><?php endif ?>
                </div>
                <?php elseif (! $isG): ?>
                <p class="where"><i class="bi bi-geo-alt-fill"></i>
                    <?= esc(trim(($m['address'] ?? '') . ($area !== '' ? ', ' . $area : ''), ', ')) ?></p>
                <?php if ($maps !== ''): ?><a class="more" href="<?= esc($maps, 'attr') ?>" target="_blank"
                    rel="noopener">Buka di peta <i class="bi bi-arrow-up-right"></i></a><?php endif ?>
                <?php endif ?>

                <div class="dt-actions">
                    <?php if ($wa !== ''): ?>
                    <a class="btn" href="<?= esc($wa, 'attr') ?>" target="_blank" rel="noopener"><i
                            class="bi bi-whatsapp"></i> Hubungi via WhatsApp</a>
                    <?php endif ?>
                    <?php if (! empty($products)): ?><a class="btn ghost" href="#produk">Lihat produk</a><?php endif ?>
                </div>
            </div>
        </div>

        <div class="facts">
            <div class="fact"><small>Hari ini</small>
                <b><?php if ($todayRow): ?><?= $todayRow['is_closed'] ? 'Tutup' : $hm($todayRow['open_time']) . ' – ' . $hm($todayRow['close_time']) ?><?php else: ?>–<?php endif ?></b>
            </div>
            <div class="fact"><small>Estimasi siap</small><b><?= (int) $m['prep_minutes'] ?> menit</b></div>
            <div class="fact"><small>Radius
                    antar</small><b><?= rtrim(rtrim(number_format((float) $m['delivery_radius_km'], 1, ',', ''), '0'), ',') ?>
                    km</b></div>
            <div class="fact"><small>Wilayah</small><b><?= esc($m['district'] ?: ($m['city'] ?: '–')) ?></b></div>
        </div>
    </div>
</section>

<section id="produk">
    <div class="w">
        <div class="sh">
            <div>
                <h2>Produk <?= esc($m['name']) ?></h2>
            </div>
        </div>
        <?php if (empty($products)): ?>
        <div class="empty">Belum ada produk yang tersedia dari <?= $isG ? 'gerobak' : 'UMKM' ?> ini.</div>
        <?php else: ?>
        <div class="grid">
            <?php foreach ($products as $p): ?>
            <?= view('partials/product_item', ['p' => $p]) ?>
            <?php endforeach ?>
        </div>
        <?php endif ?>
    </div>
</section>

<section class="tight">
    <div class="w">
        <div class="dt-cols">
            <?php if (! empty($hours)): ?>
            <div class="box">
                <h3>Jam buka</h3>
                <div class="hrs">
                    <?php foreach ($hours as $h): ?>
                    <div class="<?= $h['dn'] === $today ? 'today' : '' ?>">
                        <span><?= $days[$h['dn']] ?></span>
                        <span><?= $h['is_closed'] ? 'Tutup' : $hm($h['open_time']) . ' – ' . $hm($h['close_time']) ?></span>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
            <?php endif ?>

            <div class="box">
                <h3>Ulasan pembeli</h3>
                <?php if (empty($reviews)): ?>
                <p class="meta">Belum ada ulasan.</p>
                <?php else: ?>
                <?php foreach ($reviews as $r): ?>
                <div class="rev">
                    <div class="rt"><?php for ($i = 1; $i <= 5; $i++): ?><i
                            class="bi <?= $i <= (int) $r['rating'] ? 'bi-star-fill' : 'bi-star' ?> ic"></i><?php endfor ?>
                        <b><?= esc(explode(' ', trim($r['user_name']))[0]) ?></b>
                    </div>
                    <?php if (! empty($r['comment'])): ?><p><?= esc($r['comment']) ?></p><?php endif ?>
                    <?php if (! empty($r['seller_reply'])): ?><p class="reply"><b>Balasan penjual:</b>
                        <?= esc($r['seller_reply']) ?></p><?php endif ?>
                </div>
                <?php endforeach ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>