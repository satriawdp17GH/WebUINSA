<?php
/** Butuh: $g (array gerobak), $i (urutan stagger). */
$id = (int) $g['id'];
?>
<article class="card gcard" data-reveal style="--i:<?= (int) ($i ?? 0) ?>">
    <div class="ph tone-<?= (int) $g['tone'] ?>">
        <?= aruna_media($g['photo'] ?? null, $g['emoji'], $g['name']) ?>
        <span class="st sell"><i></i>Sedang Jualan</span>
        <span class="tag">Gerobak</span>
        <button type="button" class="fav" :class="{ on: $store.fav.has(<?= $id ?>) }"
                :aria-pressed="$store.fav.has(<?= $id ?>)" aria-label="Simpan <?= esc($g['name'], 'attr') ?> ke favorit"
                @click="$store.fav.toggle(<?= $id ?>)"><?= aruna_icon('heart', 20) ?></button>
    </div>
    <div class="cb">
        <h3><?= esc($g['name']) ?></h3>
        <p class="meta"><?= esc($g['food']) ?></p>
        <p class="where"><?= aruna_icon('pin', 16) ?> <?= esc($g['location']) ?> • <b><?= fmt_km($g['distance']) ?></b></p>
        <p class="upd"><?= aruna_icon('clock', 14) ?> Lokasi diperbarui <?= esc($g['updated']) ?></p>
        <div class="row">
            <span></span>
            <a class="btn sm stretch" href="<?= site_url('gerobak/' . $g['slug']) ?>"
               aria-label="Lihat lokasi <?= esc($g['name'], 'attr') ?>">Lihat Lokasi <?= aruna_icon('arrow', 16) ?></a>
        </div>
    </div>
</article>
