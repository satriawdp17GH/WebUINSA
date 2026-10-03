<?php

namespace App\Controllers\Traits;

/**
 * Logika daftar UMKM (type 'toko') & gerobak ('gerobak').
 * Semua data & opsi filter dari DB aruna_db (merchants, categories, products).
 * Tanpa Model/Migration: pakai Query Builder langsung.
 */
trait PublicListing
{
    protected int $perPage = 12;

    /** Parameter GET sebagai string bersih (binding query sudah aman). */
    protected function param(string $key, int $max = 100): string
    {
        return mb_substr(trim((string) $this->request->getGet($key)), 0, $max);
    }

    /** Merchant yang tampil publik: aktif & belum dihapus. */
    protected function activeMerchants(string $type = '')
    {
        $b = db_connect()->table('merchants')
            ->where('merchants.status', 'active')
            ->where('merchants.deleted_at', null);
        if ($type !== '') {
            $b->where('merchants.type', $type);
        }

        return $b;
    }

    /** Nilai unik satu kolom (A-Z, tanpa kosong). */
    protected function distinctValues($builder, string $column): array
    {
        $rows = $builder->select($column)->distinct()->where($column . ' !=', '')->orderBy($column, 'ASC')->get()->getResultArray();

        return array_map(static fn (array $r) => (string) reset($r), $rows);
    }

    /** [opsi provinsi, opsi kecamatan (menyempit sesuai provinsi), kecamatan valid]. */
    protected function areaFilters(string $type, string $prov, string $kec): array
    {
        $provOptions = $this->distinctValues($this->activeMerchants($type), 'merchants.province');

        $kb = $this->activeMerchants($type);
        if ($prov !== '') {
            $kb->where('merchants.province', $prov);
        }
        $kecOptions = $this->distinctValues($kb, 'merchants.district');

        if ($kec !== '' && ! in_array($kec, $kecOptions, true)) {
            $kec = '';
        }

        return [$provOptions, $kecOptions, $kec];
    }

    protected function categoryOptions(): array
    {
        return db_connect()->table('categories')->select('name, slug, icon')
            ->where('is_active', 1)->orderBy('sort_order', 'ASC')->get()->getResultArray();
    }

    protected function listMerchants(string $type, string $forcedCategorySlug = '')
    {
        $q    = $this->param('q');
        $prov = $this->param('provinsi');
        $kat  = $forcedCategorySlug !== '' ? $forcedCategorySlug : $this->param('kategori');
        $buka = $type === 'gerobak' && $this->param('buka', 1) === '1';
        $sort = in_array($this->param('urut', 10), ['terlaris', 'nama'], true) ? $this->param('urut', 10) : 'terbaru';

        [$provOptions, $kecOptions, $kec] = $this->areaFilters($type, $prov, $this->param('kecamatan'));

        $b = $this->activeMerchants($type)
            ->select('merchants.*, categories.name AS category_name, categories.icon AS category_icon')
            ->join('categories', 'categories.id = merchants.category_id', 'left');

        if ($q !== '') {
            $b->groupStart()
                ->like('merchants.name', $q)
                ->orLike('merchants.description', $q)
                ->orLike('merchants.location_label', $q)
                ->groupEnd();
        }
        if ($prov !== '') {
            $b->where('merchants.province', $prov);
        }
        if ($kec !== '') {
            $b->where('merchants.district', $kec);
        }
        if ($kat !== '') {
            $b->where('categories.slug', $kat);
        }
        if ($buka) {
            $b->where('merchants.is_open', 1);
        }

        $total = $b->countAllResults(false);

        match ($sort) {
            'terlaris' => $b->orderBy('merchants.sold_count', 'DESC')->orderBy('merchants.id', 'DESC'),
            'nama'     => $b->orderBy('merchants.name', 'ASC'),
            default    => $b->orderBy('merchants.id', 'DESC'),
        };

        $page  = max(1, (int) $this->request->getGet('page'));
        $items = $b->limit($this->perPage, ($page - 1) * $this->perPage)->get()->getResultArray();

        return view($type === 'gerobak' ? 'gerobak/index' : 'jelajahi/index', [
            'title'       => $type === 'gerobak' ? 'Gerobak yang Sedang Jualan — ARUNA' : 'Jelajahi UMKM — ARUNA',
            'type'        => $type,
            'items'       => $items,
            'pagerHtml'   => service('pager')->makeLinks($page, $this->perPage, $total, 'aruna'),
            'total'       => $total,
            'provOptions' => $provOptions,
            'kecOptions'  => $kecOptions,
            'katOptions'  => $this->categoryOptions(),
            'f'           => ['q' => $q, 'provinsi' => $prov, 'kecamatan' => $kec, 'kategori' => $kat, 'buka' => $buka ? '1' : '', 'urut' => $sort],
        ]);
    }

    /** Link WhatsApp (nomor 08xx dinormalisasi ke 62xx); kosong jika tak ada nomor. */
    protected function waLink(?string $phone, string $text): string
    {
        $d = preg_replace('/\D+/', '', (string) $phone);
        if ($d === '') {
            return '';
        }
        if (str_starts_with($d, '0')) {
            $d = '62' . substr($d, 1);
        }

        return 'https://wa.me/' . $d . '?text=' . rawurlencode($text);
    }

    /** Halaman detail UMKM (type 'toko') atau gerobak. */
    protected function showMerchant(string $slug, string $type)
    {
        $db = db_connect();

        $m = $db->table('merchants')
            ->select('merchants.*, categories.name AS category_name, categories.slug AS category_slug, categories.icon AS category_icon')
            ->join('categories', 'categories.id = merchants.category_id', 'left')
            ->where('merchants.slug', $slug)
            ->where('merchants.status', 'active')
            ->where('merchants.deleted_at', null)
            ->get()->getRowArray();

        if (! $m) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // /umkm/slug-gerobak atau /gerobak/slug-umkm -> arahkan ke URL yang benar
        if ($m['type'] !== $type) {
            return redirect()->to(site_url(($m['type'] === 'gerobak' ? 'gerobak' : 'umkm') . '/' . $m['slug']));
        }

        $products = $db->table('products')
            ->select('products.*, categories.name AS category_name, categories.icon AS category_icon')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.merchant_id', $m['id'])
            ->where('products.deleted_at', null)
            ->where('products.is_available', 1)
            ->orderBy('products.sold_count', 'DESC')->orderBy('products.id', 'DESC')
            ->limit(24)->get()->getResultArray();

        // Jam buka: urut Senin..Minggu (0 atau 7 = Minggu)
        $hours = $db->table('merchant_hours')->where('merchant_id', $m['id'])->get()->getResultArray();
        foreach ($hours as &$h) {
            $h['dn'] = (int) $h['day_of_week'] === 0 ? 7 : (int) $h['day_of_week'];
        }
        unset($h);
        usort($hours, static fn (array $a, array $b) => $a['dn'] <=> $b['dn']);

        $reviews = $db->table('reviews')
            ->select('reviews.rating, reviews.comment, reviews.seller_reply, reviews.created_at, users.name AS user_name')
            ->join('users', 'users.id = reviews.user_id')
            ->where('reviews.merchant_id', $m['id'])
            ->orderBy('reviews.id', 'DESC')->limit(5)->get()->getResultArray();

        return view('merchant/show', [
            'title'    => $m['name'] . ' — ARUNA',
            'm'        => $m,
            'products' => $products,
            'hours'    => $hours,
            'reviews'  => $reviews,
            'wa'       => $this->waLink($m['phone'], 'Halo ' . $m['name'] . ', saya lihat usaha Anda di ARUNA.'),
        ]);
    }
}