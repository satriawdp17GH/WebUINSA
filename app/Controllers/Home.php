<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        helper(['url', 'aruna']);

        $districts  = $this->districts();
        $slug       = (string) $this->request->getGet('kecamatan');
        $activeName = $districts[$slug] ?? null;   // null = semua kecamatan

        // TODO: ganti data contoh di bawah dengan model, mis.:
        //   $umkm = model(MerchantModel::class)->nearby($lat, $lng, ['district' => $slug, 'type' => 'toko'], 4);
        //   $gerobak = model(MerchantModel::class)->nearby($lat, $lng, ['district' => $slug, 'type' => 'gerobak', 'open' => 1], 3);
        // Bentuk array tiap item sudah sama dengan yang dibutuhkan view.
        return view('home/index', [
            'title'      => 'ARUNA — Temukan UMKM Lokal di Sekitarmu',
            'districts'  => $districts,
            'activeSlug' => $activeName ? $slug : '',
            'activeName' => $activeName,
            'categories' => [
                ['icon' => 'bi-egg-fried', 'name' => 'Makanan',   'slug' => 'makanan'],
                ['icon' => 'bi-cup-straw', 'name' => 'Minuman',   'slug' => 'minuman'],
                ['icon' => 'bi-basket2',   'name' => 'Sembako',   'slug' => 'sembako'],
                ['icon' => 'bi-tag',       'name' => 'Fashion',   'slug' => 'fashion'],
                ['icon' => 'bi-palette',   'name' => 'Kerajinan', 'slug' => 'kerajinan'],
                ['icon' => 'bi-tools',     'name' => 'Jasa',      'slug' => 'jasa'],
            ],
            'hero' => [
                ['icon' => 'bi-shop',      'emoji' => 'bi-shop',      'label' => 'Warung Bu Sari',  'photo' => null],
                ['icon' => 'bi-egg-fried', 'emoji' => 'bi-egg-fried', 'label' => 'Penjual makanan', 'photo' => null],
                ['icon' => 'bi-bicycle',   'emoji' => 'bi-bicycle',   'label' => 'Gerobak keliling', 'photo' => null],
                ['icon' => 'bi-box-seam',  'emoji' => 'bi-box-seam',  'label' => 'Produk UMKM',     'photo' => null],
                ['icon' => 'bi-cup-straw', 'emoji' => 'bi-cup-straw', 'label' => '',                'photo' => null],
                ['icon' => 'bi-truck',     'emoji' => 'bi-truck',     'label' => 'Kurir mengantar', 'photo' => null],
            ],
            'umkm' => [
                ['id' => 1, 'slug' => 'warung-bu-sari',      'name' => 'Warung Bu Sari',       'category' => 'Makanan', 'distance' => 1.2, 'rating' => 4.8, 'is_open' => true,  'eta' => '15 mnt', 'icon' => 'bi-shop',    'emoji' => 'bi-shop',    'tone' => 1, 'photo' => null],
                ['id' => 2, 'slug' => 'kopi-kelana',         'name' => 'Kopi Kelana',          'category' => 'Minuman', 'distance' => 0.8, 'rating' => 4.7, 'is_open' => true,  'eta' => '10 mnt', 'icon' => 'bi-cup-hot', 'emoji' => 'bi-cup-hot', 'tone' => 2, 'photo' => null],
                ['id' => 3, 'slug' => 'toko-sembako-makmur', 'name' => 'Toko Sembako Makmur',  'category' => 'Sembako', 'distance' => 2.1, 'rating' => 4.6, 'is_open' => true,  'eta' => '20 mnt', 'icon' => 'bi-basket2', 'emoji' => 'bi-basket2', 'tone' => 4, 'photo' => null],
                ['id' => 4, 'slug' => 'batik-ningrum',       'name' => 'Batik Ningrum',        'category' => 'Fashion', 'distance' => 3.4, 'rating' => 4.9, 'is_open' => false, 'eta' => 'Tutup',  'icon' => 'bi-gem',     'emoji' => 'bi-gem',     'tone' => 5, 'photo' => null],
            ],
            'gerobak' => [
                ['id' => 11, 'slug' => 'bakso-pak-darto',     'name' => 'Bakso Pak Darto',     'food' => 'Bakso & mie ayam',        'location' => 'Jl. Raya Darmo', 'distance' => 1.4, 'updated' => '2 menit lalu',  'icon' => 'bi-egg-fried',  'emoji' => 'bi-egg-fried',  'tone' => 3, 'photo' => null],
                ['id' => 12, 'slug' => 'es-dawet-mbak-rini',  'name' => 'Es Dawet Mbak Rini',  'food' => 'Minuman tradisional',     'location' => 'Taman Bungkul',  'distance' => 2.0, 'updated' => '6 menit lalu',  'icon' => 'bi-cup-straw',  'emoji' => 'bi-cup-straw',  'tone' => 2, 'photo' => null],
                ['id' => 13, 'slug' => 'martabak-bang-ucok',  'name' => 'Martabak Bang Ucok',  'food' => 'Martabak manis & telur',  'location' => 'Jl. Ngagel',     'distance' => 2.6, 'updated' => '11 menit lalu', 'icon' => 'bi-cake2',      'emoji' => 'bi-cake2',      'tone' => 5, 'photo' => null],
            ],
            'products' => [
                ['id' => 101, 'name' => 'Nasi Ayam',          'merchant' => 'Warung Bu Sari',   'merchant_id' => 1, 'price' => 15000, 'rating' => 4.9, 'icon' => 'bi-egg-fried', 'emoji' => 'bi-egg-fried', 'tone' => 1, 'photo' => null, 'slug' => 'nasi-ayam'],
                ['id' => 102, 'name' => 'Es Kopi Susu',       'merchant' => 'Kopi Kelana',      'merchant_id' => 2, 'price' => 18000, 'rating' => 4.8, 'icon' => 'bi-cup-straw', 'emoji' => 'bi-cup-straw', 'tone' => 2, 'photo' => null, 'slug' => 'es-kopi-susu'],
                ['id' => 103, 'name' => 'Tempe Mendoan (5)',  'merchant' => 'Dapur Ibu Wati',   'merchant_id' => 5, 'price' => 10000, 'rating' => 4.7, 'icon' => 'bi-fire',      'emoji' => 'bi-fire',      'tone' => 4, 'photo' => null, 'slug' => 'tempe-mendoan'],
                ['id' => 104, 'name' => 'Sambal Bawang 200g', 'merchant' => 'Sambal Nusantara', 'merchant_id' => 8, 'price' => 22000, 'rating' => 4.9, 'icon' => 'bi-droplet',   'emoji' => 'bi-droplet',   'tone' => 5, 'photo' => null, 'slug' => 'sambal-bawang'],
            ],
            'featured' => [
                ['id' => 5, 'slug' => 'dapur-ibu-wati',         'name' => 'Dapur Ibu Wati',          'category' => 'Makanan',   'rating' => 4.9, 'area' => 'Gubeng',     'icon' => 'bi-shop',     'emoji' => 'bi-shop',     'tone' => 3, 'photo' => null],
                ['id' => 6, 'slug' => 'anyaman-lestari',        'name' => 'Anyaman Lestari',         'category' => 'Kerajinan', 'rating' => 4.8, 'area' => 'Rungkut',    'icon' => 'bi-basket2',  'emoji' => 'bi-basket2',  'tone' => 4, 'photo' => null],
                ['id' => 7, 'slug' => 'jahit-cepat-pak-yanto',  'name' => 'Jahit Cepat Pak Yanto',   'category' => 'Jasa',      'rating' => 4.8, 'area' => 'Wonokromo',  'icon' => 'bi-scissors', 'emoji' => 'bi-scissors', 'tone' => 2, 'photo' => null],
                ['id' => 8, 'slug' => 'sambal-nusantara',       'name' => 'Sambal Nusantara',        'category' => 'Makanan',   'rating' => 4.9, 'area' => 'Tegalsari',  'icon' => 'bi-fire',     'emoji' => 'bi-fire',     'tone' => 5, 'photo' => null],
            ],
        ]);
    }

    /** slug => nama. Ganti dengan tabel `districts` bila sudah ada. */
    private function districts(): array
    {
        $names = [
            'Asemrowo', 'Benowo', 'Bubutan', 'Bulak', 'Dukuh Pakis', 'Gayungan', 'Genteng', 'Gubeng',
            'Gunung Anyar', 'Jambangan', 'Karang Pilang', 'Kenjeran', 'Krembangan', 'Lakarsantri',
            'Mulyorejo', 'Pabean Cantian', 'Pakal', 'Rungkut', 'Sambikerep', 'Sawahan', 'Semampir',
            'Simokerto', 'Sukolilo', 'Sukomanunggal', 'Tambaksari', 'Tandes', 'Tegalsari',
            'Tenggilis Mejoyo', 'Wiyung', 'Wonocolo', 'Wonokromo',
        ];

        $out = [];
        foreach ($names as $n) {
            $out[url_title($n, '-', true)] = $n;
        }

        return $out;
    }
}