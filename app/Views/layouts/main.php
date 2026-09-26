<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title><?= esc($title ?? 'ARUNA — Gerakkan Usahamu, Tumbuh Bersama') ?></title>
    <meta name="description"
        content="Belanja produk lokal, pesan dari UMKM favorit, atau temukan gerobak yang sedang jualan di dekatmu.">
    <meta name="theme-color" content="#16294d">
    <meta name="csrf-token" content="<?= csrf_hash() ?>" data-header="<?= csrf_header() ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/aruna.css') ?>">

    <script>
    document.documentElement.classList.add('js')
    </script>
    <!-- aruna.js harus dimuat SEBELUM Alpine agar store terdaftar pada alpine:init -->
    <script defer src="<?= base_url('assets/js/aruna.js') ?>"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <!-- Bootstrap 5 Bundle JS (termasuk Popper) untuk komponen JS interaktif -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body x-data x-effect="document.body.classList.toggle('lock', $store.cart.open)">
    <a class="skip" href="#main">Lewati ke konten</a>

    <?= $this->include('partials/navbar') ?>

    <main id="main">
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('partials/footer') ?>
    <?= $this->include('partials/bottom_nav') ?>
    <?= $this->include('partials/cart_drawer') ?>

    <div class="toast" :class="{ show: $store.toast.on }" role="status" aria-live="polite">
        <?= aruna_icon('check', 18) ?><span x-text="$store.toast.msg"></span>
    </div>

    <?= $this->renderSection('scripts') ?>
</body>

</html>