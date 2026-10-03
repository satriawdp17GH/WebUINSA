<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="static-page" x-data="{ open: 1 }">

    <div class="w">

        <div class="static-hero">
            <span class="static-eyebrow">
                <?= aruna_icon('help', 15) ?>
                FAQ
            </span>

            <h1>Pertanyaan yang sering ditanyakan.</h1>

            <p>
                Beberapa jawaban untuk membantu kamu memahami
                cara menggunakan ARUNA.
            </p>
        </div>

        <div class="faq-list">

            <?php
            $faqs = [
                [
                    'Apa itu ARUNA?',
                    'ARUNA adalah platform digital yang membantu masyarakat menemukan UMKM, produk lokal, dan pedagang gerobak di sekitar mereka.'
                ],
                [
                    'Siapa saja yang dapat menggunakan ARUNA?',
                    'ARUNA dapat digunakan oleh masyarakat sebagai pembeli maupun pelaku UMKM yang ingin menjangkau pelanggan secara digital.'
                ],
                [
                    'Apakah saya bisa mencari produk tertentu?',
                    'Bisa. Kamu dapat menggunakan fitur pencarian untuk mencari produk, makanan, maupun nama UMKM.'
                ],
                [
                    'Apakah saya bisa melihat UMKM di sekitar saya?',
                    'Bisa. ARUNA dapat menampilkan UMKM berdasarkan kecamatan atau lokasi yang tersedia pada platform.'
                ],
                [
                    'Apa yang dimaksud dengan UMKM Gerobak?',
                    'UMKM Gerobak merupakan pedagang yang berjualan secara berpindah-pindah. Pemilik dapat memperbarui lokasi jualannya agar pelanggan dapat menemukannya.'
                ],
                [
                    'Bagaimana cara bergabung sebagai UMKM?',
                    'Kamu dapat memilih menu bergabung sebagai UMKM dan mengikuti proses pendaftaran yang tersedia.'
                ],
                [
                    'Bagaimana jika saya mengalami masalah dengan pesanan?',
                    'Kamu dapat menghubungi tim ARUNA melalui halaman Hubungi Kami dengan menjelaskan kendala yang terjadi.'
                ],
            ];
            ?>

            <?php foreach ($faqs as $i => $faq): ?>

            <div class="faq-item">

                <button type="button" class="faq-q" @click="open = open === <?= $i ?> ? null : <?= $i ?>"
                    :aria-expanded="open === <?= $i ? 'true' : 'false' ?>">
                    <span><?= esc($faq[0]) ?></span>

                    <span class="faq-arrow">
                        <?= aruna_icon('chevron', 17) ?>
                    </span>
                </button>

                <div x-show="open === <?= $i ?>" x-collapse class="faq-a">
                    <?= esc($faq[1]) ?>
                </div>

            </div>

            <?php endforeach ?>

        </div>

    </div>

</section>

<?= $this->endSection() ?>