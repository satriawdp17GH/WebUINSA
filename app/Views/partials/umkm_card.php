<?php
/** Butuh: $m (array UMKM), $i (urutan untuk stagger animasi). */
$open = ! empty($m['is_open']);
$id   = (int) $m['id'];
?>
<article class="card umkm <?= $open ? '' : 'is-closed' ?>" data-reveal style="--i:<?= (int) ($i ?? 0) ?>">
    <div class="ph tone-<?= (int) $m['tone'] ?>">
        <?= aruna_media($m['photo'] ?? null, $m['emoji'], $m['name']) ?>
        <span class="st <?= $open ? 'on' : 'off' ?>"><i></i><?= $open ? 'Buka' : 'Tutup' ?></span>
        <button type="button" class="fav" :class="{ on: $store.fav.has(<?= $id ?>) }"
                :aria-pressed="$store.fav.has(<?= $id ?>)" aria-label="Simpan <?= esc($m['name'], 'attr') ?> ke favorit"
                @click="$store.fav.toggle(<?= $id ?>)"><?= aruna_icon('heart', 20) ?></button>
    </div>
    <div class="cb">
        <h3><?= esc($m['name']) ?></h3>
        <p class="meta"><?= esc($m['category']) ?> • <?= fmt_km($m['distance']) ?> • <?= esc($m['eta']) ?></p>
        <div class="row">
            <span class="rt"><?= aruna_icon('star', 15) ?> <?= fmt_rating($m['rating']) ?></span>
            <a class="btn sm navy stretch" href="<?= site_url('umkm/' . $m['slug']) ?>"
               aria-label="Lihat toko <?= esc($m['name'], 'attr') ?>">Lihat Toko <?= aruna_icon('arrow', 16) ?></a>
        </div>
    </div>
</article>
