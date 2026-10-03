<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="static-page">

    <div class="w">

        <div class="static-hero">
            <span class="static-eyebrow">
                <?= aruna_icon('heart', 15) ?>
                Tentang ARUNA
            </span>

            <h1>
                Menghubungkan kamu dengan
                <span style="color:var(--or)">UMKM lokal.</span>
            </h1>

            <p>
                ARUNA adalah platform yang membantu masyarakat menemukan
                produk dan usaha lokal di sekitar mereka dengan cara yang
                lebih mudah, praktis, dan terhubung.
            </p>
        </div>

        <div class="about-grid">

            <div class="about-card">
                <div class="about-icon">
                    <?= aruna_icon('map', 25) ?>
                </div>

                <h3>Temukan Lokal</h3>

                <p>
                    Temukan berbagai UMKM, produk, dan gerobak yang
                    sedang berjualan di sekitar lokasimu.
                </p>
            </div>

            <div class="about-card">
                <div class="about-icon">
                    <?= aruna_icon('bag', 25) ?>
                </div>

                <h3>Pesan dengan Mudah</h3>

                <p>
                    Pilih produk favoritmu, lakukan pemesanan, dan
                    nikmati pengalaman belanja lokal yang lebih praktis.
                </p>
            </div>

            <div class="about-card">
                <div class="about-icon">
                    <?= aruna_icon('shop', 25) ?>
                </div>

                <h3>Dukung UMKM</h3>

                <p>
                    Membantu usaha lokal mendapatkan akses pelanggan
                    yang lebih luas melalui teknologi digital.
                </p>
            </div>

        </div>

        <div class="static-highlight">

            <div>
                <h2>Untuk UMKM yang ingin terus tumbuh.</h2>

                <p>
                    ARUNA membantu pemilik usaha mengelola produk,
                    menerima pesanan, dan menjangkau pelanggan
                    dalam satu platform.
                </p>
            </div>

            <a href="<?= site_url('gabung/umkm') ?>" class="btn light">
                Gabung Sebagai UMKM
                <?= aruna_icon('arrow', 17) ?>
            </a>

        </div>

        <div class="static-box" style="margin-top:20px">

            <h2>Kenapa ARUNA?</h2>

            <p>
                Banyak usaha lokal memiliki produk yang menarik, tetapi
                belum semuanya mudah ditemukan secara digital. Pada saat
                yang sama, masyarakat ingin menemukan pilihan produk lokal
                tanpa harus mengetahui terlebih dahulu nama atau lokasi
                penjualnya.
            </p>

            <p style="margin-top:14px">
                ARUNA hadir untuk mempertemukan kedua kebutuhan tersebut.
                Dengan memanfaatkan teknologi digital, kami ingin membuat
                produk lokal lebih mudah ditemukan dan membantu UMKM
                menjangkau pelanggan di sekitarnya.
            </p>

        </div>

    </div>

</section>

<?= $this->endSection() ?>