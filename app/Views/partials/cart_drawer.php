<div class="ov" :class="{ open: $store.cart.open }" @click="$store.cart.open = false"></div>

<aside class="drawer" :class="{ open: $store.cart.open }" :inert="!$store.cart.open"
       role="dialog" aria-modal="true" aria-label="Keranjang"
       @keydown.escape.window="$store.cart.open = false">
    <div class="dh">
        <div>
            <h2>Keranjang</h2>
            <p class="meta" x-show="$store.cart.count" x-cloak>
                Pesanan dari <b x-text="$store.cart.merchant"></b>
            </p>
        </div>
        <button type="button" class="ib" aria-label="Tutup keranjang" @click="$store.cart.open = false"><?= aruna_icon('close') ?></button>
    </div>

    <!-- Satu keranjang hanya untuk satu UMKM -->
    <div class="warn" x-show="$store.cart.conflict" x-cloak>
        <p>Keranjangmu berisi pesanan dari <b x-text="$store.cart.merchant"></b>.
           Ganti dengan produk dari <b x-text="$store.cart.conflict?.merchant"></b>?</p>
        <div>
            <button type="button" class="btn sm" @click="$store.cart.replaceWith()">Ganti keranjang</button>
            <button type="button" class="btn sm ghost" @click="$store.cart.keep()">Batal</button>
        </div>
    </div>

    <div class="db">
        <div class="empty-cart" x-show="!$store.cart.count" x-cloak>
            <span><i class="bi bi-bag-x" style="font-size:2.8rem;color:var(--mut)"></i></span>
            <p><b>Keranjangmu masih kosong</b></p>
            <p class="meta">Pilih menu dari UMKM di sekitarmu, lalu tekan tombol +.</p>
            <button type="button" class="btn sm navy" @click="$store.cart.open = false">Mulai belanja</button>
        </div>

        <template x-for="it in $store.cart.items" :key="it.id">
            <div class="ci">
                <div class="th">
                    <img x-show="it.img" :src="it.img" :alt="it.name" loading="lazy">
                    <span x-show="!it.img && it.emoji?.startsWith('bi-')" :class="'bi ' + it.emoji" aria-hidden="true"></span>
                    <span x-show="!it.img && !it.emoji?.startsWith('bi-')" x-text="it.emoji" aria-hidden="true"></span>
                </div>
                <div class="info">
                    <b x-text="it.name"></b>
                    <small x-text="$store.cart.rp(it.price)"></small>
                </div>
                <div class="qty" role="group" :aria-label="'Jumlah ' + it.name">
                    <button type="button" @click="$store.cart.dec(it.id)" aria-label="Kurangi"><?= aruna_icon('minus', 16) ?></button>
                    <span x-text="it.qty"></span>
                    <button type="button" @click="$store.cart.inc(it.id)" aria-label="Tambah"><?= aruna_icon('plus', 16) ?></button>
                </div>
            </div>
        </template>
    </div>

    <div class="df">
        <div class="tot"><span>Subtotal</span><b x-text="$store.cart.rp($store.cart.total)"></b></div>
        <p class="meta">Ongkos kirim dihitung saat checkout.</p>
        <a class="btn" href="<?= site_url('checkout') ?>"
           :class="{ disabled: !$store.cart.count }" :aria-disabled="!$store.cart.count"
           @click="if (!$store.cart.count) $event.preventDefault()">
            Lanjut ke Checkout <?= aruna_icon('arrow', 18) ?>
        </a>
        <button type="button" class="clear" x-show="$store.cart.count" x-cloak @click="$store.cart.clear()">Kosongkan keranjang</button>
    </div>
</aside>
