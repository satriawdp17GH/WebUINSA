<?php
/** Butuh: $f (array UMKM pilihan). */
?>
<a class="hc" href="<?= site_url('umkm/' . $f['slug']) ?>">
    <div class="ph tone-<?= (int) $f['tone'] ?>">
        <?= aruna_media($f['photo'] ?? null, $f['emoji'], $f['name']) ?>
    </div>
    <div class="hi">
        <h3><?= esc($f['name']) ?></h3>
        <p class="meta"><?= esc($f['category']) ?></p>
        <p class="meta"><?= aruna_icon('pin', 14) ?> <?= esc($f['area']) ?>, Surabaya</p>
        <span class="rt"><?= aruna_icon('star', 15) ?> <?= fmt_rating($f['rating']) ?></span>
    </div>
    <span class="hgo" aria-hidden="true"><?= aruna_icon('arrow', 18) ?></span>
</a>
