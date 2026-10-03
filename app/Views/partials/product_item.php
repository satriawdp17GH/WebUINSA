<?php
/**
 * Kartu produk (daftar /produk, detail UMKM/gerobak, produk lain).
 * Butuh: $p (products.* + category_name/category_icon).
 * Opsional: merchant_type, merchant_name, merchant_district (dari join merchants).
 */
$imgUrl = static fn (string $x): string => preg_match('#^https?://#', $x) ? $x : base_url($x);
$mt     = $p['merchant_type'] ?? null;
?>
<article class="card pcard">
    <div class="ph tone-<?= ($p['id'] % 6) + 1 ?>">
        <?php if (! empty($p['photo'])): ?>
        <img src="<?= esc($imgUrl($p['photo']), 'attr') ?>" alt="<?= esc($p['name'], 'attr') ?>" loading="lazy">
        <?php else: ?>
        <span
            class="emo"><?= ! empty($p['category_icon']) ? esc($p['category_icon']) : '<i class="bi bi-bag-fill"></i>' ?></span>
        <?php endif ?>
        <?php if ($mt): ?><span class="tag"><?= $mt === 'gerobak' ? 'Gerobak' : 'UMKM' ?></span><?php endif ?>
    </div>
    <div class="cb">
        <h3><a class="stretch" href="<?= site_url('produk/' . $p['slug']) ?>"><?= esc($p['name']) ?></a></h3>
        <?php if (! empty($p['merchant_name'])): ?>
        <p class="meta">
            <?= esc($p['merchant_name']) ?><?= ! empty($p['merchant_district']) ? ' • ' . esc($p['merchant_district']) : '' ?>
        </p>
        <?php endif ?>
        <div class="row">
            <span class="price">Rp<?= number_format((int) $p['price'], 0, ',', '.') ?></span>
            <?php if ((int) $p['rating_count'] > 0): ?>
            <span class="rt"><i class="bi bi-star-fill ic"></i> <?= number_format((float) $p['rating_avg'], 1) ?></span>
            <?php elseif (! empty($p['category_name'])): ?>
            <span class="meta"><?= esc($p['category_name']) ?></span>
            <?php endif ?>
        </div>
    </div>
</article>