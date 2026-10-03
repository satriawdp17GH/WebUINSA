<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="static-page">

    <div class="w">

        <div class="static-hero">

            <span class="static-eyebrow">
                <?= aruna_icon('message', 15) ?>
                Bantuan ARUNA
            </span>

            <h1>Ada yang ingin kamu tanyakan?</h1>

            <p>
                Hubungi kami jika kamu memiliki pertanyaan, saran,
                atau mengalami kendala ketika menggunakan ARUNA.
            </p>

        </div>

        <?php if (session()->getFlashdata('success')): ?>

        <div class="alert-aruna">
            <?= aruna_icon('check', 17) ?>

            <?= esc(session()->getFlashdata('success')) ?>
        </div>

        <?php endif ?>

        <div class="contact-grid">

            <!-- INFO -->
            <div class="contact-info">

                <h2>Mari terhubung.</h2>

                <p>
                    Kami terbuka untuk pertanyaan, masukan, maupun
                    laporan kendala yang kamu alami saat menggunakan
                    ARUNA.
                </p>

                <div class="contact-item">

                    <div class="contact-item-icon">
                        <?= aruna_icon('mail', 18) ?>
                    </div>

                    <div>
                        <strong>Email</strong>
                        <span>hello@aruna.id</span>
                    </div>

                </div>

                <div class="contact-item">

                    <div class="contact-item-icon">
                        <?= aruna_icon('phone', 18) ?>
                    </div>

                    <div>
                        <strong>WhatsApp</strong>
                        <span>Tim bantuan ARUNA</span>
                    </div>

                </div>

                <div class="contact-item">

                    <div class="contact-item-icon">
                        <?= aruna_icon('clock', 18) ?>
                    </div>

                    <div>
                        <strong>Jam Layanan</strong>
                        <span>Senin – Jumat, 08.00 – 17.00</span>
                    </div>

                </div>

            </div>


            <!-- FORM -->
            <div class="contact-form">

                <h2 style="margin-bottom:22px">
                    Kirim pesan
                </h2>

                <form action="<?= site_url('hubungi-kami') ?>" method="post">

                    <?= csrf_field() ?>

                    <div class="form-group">

                        <label for="name">
                            Nama
                        </label>

                        <input id="name" type="text" name="name" class="form-control-aruna" placeholder="Nama kamu"
                            required>

                    </div>

                    <div class="form-group">

                        <label for="email">
                            Email
                        </label>

                        <input id="email" type="email" name="email" class="form-control-aruna"
                            placeholder="nama@email.com" required>

                    </div>

                    <div class="form-group">

                        <label for="subject">
                            Subjek
                        </label>

                        <input id="subject" type="text" name="subject" class="form-control-aruna"
                            placeholder="Apa yang ingin kamu tanyakan?" required>

                    </div>

                    <div class="form-group">

                        <label for="message">
                            Pesan
                        </label>

                        <textarea id="message" name="message" class="form-control-aruna"
                            placeholder="Tulis pesan kamu..." required></textarea>

                    </div>

                    <button type="submit" class="btn">
                        Kirim Pesan
                        <?= aruna_icon('arrow', 17) ?>
                    </button>

                </form>

            </div>

        </div>

    </div>

</section>

<?= $this->endSection() ?>