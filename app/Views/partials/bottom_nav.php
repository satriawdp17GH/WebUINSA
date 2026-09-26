<?php
$seg  = service('request')->getUri()->getSegment(1);
$user = session()->get('user');
$items = [
    ['Beranda',  '',         '',         'home'],
    ['Jelajahi', 'jelajahi', 'jelajahi', 'compass'],
    ['Gerobak',  'gerobak',  'gerobak',  'pin'],
    ['Pesanan',  'pesanan',  'pesanan',  'receipt'],
    ['Akun',     $user ? 'akun' : 'masuk', $user ? 'akun' : 'masuk', 'user'],
];
?>
<nav class="bn" aria-label="Navigasi bawah">
    <?php foreach ($items as [$label, $href, $key, $icon]): ?>
        <a href="<?= site_url($href) ?>" class="<?= $seg === $key ? 'on' : '' ?>" <?= $seg === $key ? 'aria-current="page"' : '' ?>>
            <?= aruna_icon($icon, 22) ?><span><?= esc($label) ?></span>
        </a>
    <?php endforeach ?>
</nav>
