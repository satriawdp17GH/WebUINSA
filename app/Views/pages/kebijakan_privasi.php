<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="static-page">

    <div class="w">

        <div class="static-hero">

            <span class="static-eyebrow">
                <?= aruna_icon('lock', 15) ?>
                Privasi
            </span>

            <h1>Kebijakan Privasi</h1>

            <p>
                Kami menghargai privasi dan berkomitmen untuk menjaga
                informasi yang diberikan pengguna saat menggunakan ARUNA.
            </p>

        </div>

        <div class="static-content">

            <div class="legal-meta">
                <?= aruna_icon('calendar', 15) ?>
                Terakhir diperbarui: 3 Oktober 2026
            </div>

            <div class="legal-toc">
                <a href="#informasi">Informasi</a>
                <a href="#penggunaan">Penggunaan</a>
                <a href="#keamanan">Keamanan</a>
                <a href="#hak">Hak Pengguna</a>
            </div>

            <div class="static-box" id="informasi">

                <h2>1. Informasi yang Dikumpulkan</h2>

                <p>
                    Saat menggunakan layanan ARUNA, pengguna dapat memberikan
                    informasi seperti nama, nomor telepon, alamat, informasi
                    akun, dan informasi yang berkaitan dengan transaksi.
                </p>

            </div>

            <div class="static-box" id="penggunaan">

                <h2>2. Penggunaan Informasi</h2>

                <p>
                    Informasi pengguna dapat digunakan untuk menyediakan
                    layanan ARUNA, memproses pesanan, membantu pengguna,
                    meningkatkan kualitas layanan, dan menjaga keamanan
                    platform.
                </p>

            </div>

            <div class="static-box" id="keamanan">

                <h2>3. Keamanan Informasi</h2>

                <p>
                    ARUNA berupaya menerapkan langkah-langkah keamanan yang
                    sesuai untuk melindungi informasi pengguna dari akses,
                    penggunaan, atau perubahan yang tidak sah.
                </p>

            </div>

            <div class="static-box">

                <h2>4. Pembagian Informasi</h2>

                <p>
                    Informasi pengguna tidak dibagikan secara sembarangan.
                    Informasi dapat digunakan atau dibagikan apabila
                    diperlukan untuk menyediakan layanan, memenuhi kewajiban
                    hukum, atau menjaga keamanan platform.
                </p>

            </div>

            <div class="static-box" id="hak">

                <h2>5. Hak Pengguna</h2>

                <p>Pengguna dapat memiliki hak untuk:</p>

                <ul>
                    <li>Mengakses informasi akun.</li>
                    <li>Memperbarui informasi yang tidak sesuai.</li>
                    <li>Meminta bantuan terkait penggunaan informasi.</li>
                    <li>Menghubungi ARUNA terkait pertanyaan privasi.</li>
                </ul>

            </div>

            <div class="static-box">

                <h2>6. Perubahan Kebijakan</h2>

                <p>
                    Kebijakan Privasi ini dapat diperbarui dari waktu ke
                    waktu sesuai perkembangan layanan ARUNA dan kebutuhan
                    keamanan pengguna.
                </p>

            </div>

        </div>

    </div>

</section>

<?= $this->endSection() ?>