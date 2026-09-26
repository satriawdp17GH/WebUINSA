<?php
/** Butuh: $p (array produk), $i (urutan stagger). */
$payload = [
    'id'         => (int) $p['id'],
    'name'       => $p['name'],
    'merchant'   => $p['merchant'],
    'merchantId' => (int) $p['merchant_id'],
    'price'      => (int) $p['price'],
    'emoji'      => $p['emoji'],
    'img'        => ! empty($p['photo']) ? base_url('uploads/' . $p['photo']) : null,
];
?>
<article class="card pcard" data-reveal style="--i:<?= (int) ($i ?? 0) ?>">
    <div class="ph tone-<?= (int) $p['tone'] ?>">
        <?= aruna_media($p['photo'] ?? null, $p['emoji'], $p['name']) ?>
    </div>
    <div class="cb">
        <h3><a class="stretch" href="<?= site_url('produk/' . $p['slug']) ?>"><?= esc($p['name']) ?></a></h3>
        <p class="meta"><?= esc($p['merchant']) ?></p>
        <div class="row">
            <div>
                <div class="price"><?= fmt_rupiah($p['price']) ?></div>
                <span class="rt"><?= aruna_icon('star', 15) ?> <?= fmt_rating($p['rating']) ?></span>
            </div>
            <button type="button" class="add" x-data="{ ok: false }" :class="{ done: ok }"
                    data-product="<?= esc(json_encode($payload, JSON_UNESCAPED_UNICODE), 'attr') ?>"
                    aria-label="Tambah <?= esc($p['name'], 'attr') ?> ke keranjang"
                    @click="$store.cart.add(JSON.parse($el.dataset.product)); ok = true; setTimeout(() => ok = false, 900)">
                <span x-show="!ok"><?= aruna_icon('plus', 22) ?></span>
                <span x-show="ok" x-cloak><?= aruna_icon('check', 22) ?></span>
            </button>
        </div>
    </div>
</article>
