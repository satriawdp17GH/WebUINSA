<?php
$cols = [
    'Jelajahi' => [
        ['UMKM di Sekitarmu', 'jelajahi'], ['Gerobak Keliling', 'gerobak'],
        ['Produk Populer', 'produk'], ['Kategori', 'kategori/makanan'],
    ],
    'Untuk UMKM' => [
        ['Gabung Sebagai UMKM', 'gabung/umkm'], ['Daftar UMKM Gerobak', 'gabung/gerobak'],
        ['Dashboard Penjual', 'seller'],
    ],
    'Bantuan' => [
        ['FAQ', 'faq'], ['Cara Memesan', 'faq'], ['Hubungi Kami', 'hubungi-kami'],
    ],
    'Tentang ARUNA' => [
        ['Kisah Kami', 'tentang'], ['Kebijakan Privasi', 'kebijakan-privasi'],
        ['Syarat & Ketentuan', 'syarat-ketentuan'],
    ],
];
?>
<footer class="ft">
    <div class="w">
        <div class="fg">
            <div class="fbrand">
                <div class="logo"><?= aruna_logo(30) ?><span>ARUNA</span></div>
                <p class="tag-line">Gerakkan Usahamu, Tumbuh Bersama.</p>
                <p class="meta">Arus usaha yang membantu UMKM bergerak dan berkembang. Kini hadir di Surabaya.</p>
            </div>
            <?php foreach ($cols as $title => $links): ?>
                <div>
                    <h4><?= esc($title) ?></h4>
                    <?php foreach ($links as [$label, $href]): ?>
                        <a href="<?= site_url($href) ?>"><?= esc($label) ?></a>
                    <?php endforeach ?>
                </div>
            <?php endforeach ?>
        </div>
        <div class="fb">
            <a href="<?= site_url('kebijakan-privasi') ?>">Kebijakan Privasi</a>
            <a href="<?= site_url('syarat-ketentuan') ?>">Syarat &amp; Ketentuan</a>
            <a href="<?= site_url('faq') ?>">FAQ</a>
            <a href="<?= site_url('hubungi-kami') ?>">Hubungi Kami</a>
            <span>© <?= date('Y') ?> ARUNA</span>
        </div>
    </div>
</footer>
