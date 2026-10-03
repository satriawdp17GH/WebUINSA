<?php

namespace App\Controllers;

use App\Controllers\Traits\PublicListing;

/**
 * Publik:
 *  GET produk -> index (semua produk toko + gerobak, dengan filter)
 *  GET produk/(:segment) -> show (detail produk + info penjual)
 */
class Products extends BaseController
{
    use PublicListing;

    public function index()
    {
        $q    = $this->param('q');
        $tipe = in_array($this->param('tipe', 10), ['toko', 'gerobak'], true) ? $this->param('tipe', 10) : '';
        $prov = $this->param('provinsi');
        $kat  = $this->param('kategori');
        $min  = max(0, (int) $this->request->getGet('min'));
        $max  = max(0, (int) $this->request->getGet('max'));
        $sort = in_array($this->param('urut', 10), ['terlaris', 'termurah', 'termahal', 'nama'], true) ? $this->param('urut', 10) : '';

        [$provOptions, $kecOptions, $kec] = $this->areaFilters($tipe, $prov, $this->param('kecamatan'));

        $b = db_connect()->table('products')
            ->select('products.*, merchants.name AS merchant_name, merchants.type AS merchant_type, '
                . 'merchants.district AS merchant_district, merchants.city AS merchant_city, '
                . 'categories.name AS category_name, categories.icon AS category_icon')
            ->join('merchants', 'merchants.id = products.merchant_id')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('merchants.status', 'active')
            ->where('merchants.deleted_at', null)
            ->where('products.deleted_at', null)
            ->where('products.is_available', 1);

        if ($q !== '') {
            $b->groupStart()
                ->like('products.name', $q)
                ->orLike('products.description', $q)
                ->orLike('merchants.name', $q)
                ->groupEnd();
        }
        if ($tipe !== '') {
            $b->where('merchants.type', $tipe);
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
        if ($min > 0) {
            $b->where('products.price >=', $min);
        }
        if ($max > 0) {
            $b->where('products.price <=', $max);
        }

        $total = $b->countAllResults(false);

        match ($sort) {
            'terlaris' => $b->orderBy('products.sold_count', 'DESC')->orderBy('products.id', 'DESC'),
            'termurah' => $b->orderBy('products.price', 'ASC'),
            'termahal' => $b->orderBy('products.price', 'DESC'),
            'nama'     => $b->orderBy('products.name', 'ASC'),
            default    => $b->orderBy('products.id', 'DESC'),
        };

        $page  = max(1, (int) $this->request->getGet('page'));
        $items = $b->limit($this->perPage, ($page - 1) * $this->perPage)->get()->getResultArray();

        return view('produk/index', [
            'title'       => 'Semua Produk — ARUNA',
            'items'       => $items,
            'pagerHtml'   => service('pager')->makeLinks($page, $this->perPage, $total, 'aruna'),
            'total'       => $total,
            'provOptions' => $provOptions,
            'kecOptions'  => $kecOptions,
            'katOptions'  => $this->categoryOptions(),
            'f'           => [
                'q' => $q, 'tipe' => $tipe, 'provinsi' => $prov, 'kecamatan' => $kec, 'kategori' => $kat,
                'min' => $min ?: '', 'max' => $max ?: '', 'urut' => $sort,
            ],
        ]);
    }

    /**
     * GET produk/(:segment) -> keterangan produk + info penjual (toko / gerobak).
     * Slug produk unik per penjual; bila ada slug kembar, tambahkan ?toko=slug-penjual.
     */
    public function show(string $slug)
    {
        $db = db_connect();

        $b = $db->table('products')
            ->select('products.*, categories.name AS category_name, categories.icon AS category_icon, '
                . 'merchants.name AS m_name, merchants.slug AS m_slug, merchants.type AS m_type, merchants.phone AS m_phone, '
                . 'merchants.is_open AS m_is_open, merchants.district AS m_district, merchants.city AS m_city, '
                . 'merchants.province AS m_province, merchants.address AS m_address, merchants.photo AS m_photo, '
                . 'merchants.location_label AS m_location_label, merchants.location_updated_at AS m_location_updated_at, '
                . 'merchants.rating_avg AS m_rating_avg, merchants.rating_count AS m_rating_count, '
                . 'merchants.prep_minutes AS m_prep_minutes, merchants.latitude AS m_latitude, merchants.longitude AS m_longitude, '
                . 'mc.icon AS m_category_icon, mc.name AS m_category_name')
            ->join('merchants', 'merchants.id = products.merchant_id')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->join('categories mc', 'mc.id = merchants.category_id', 'left')
            ->where('products.slug', $slug)
            ->where('products.deleted_at', null)
            ->where('merchants.status', 'active')
            ->where('merchants.deleted_at', null);

        $toko = $this->param('toko');
        if ($toko !== '') {
            $b->where('merchants.slug', $toko);
        }

        $p = $b->orderBy('products.id', 'ASC')->get(1)->getRowArray();
        if (! $p) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $others = $db->table('products')
            ->select('products.*, categories.name AS category_name, categories.icon AS category_icon')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.merchant_id', $p['merchant_id'])
            ->where('products.id !=', $p['id'])
            ->where('products.deleted_at', null)
            ->where('products.is_available', 1)
            ->orderBy('products.sold_count', 'DESC')->orderBy('products.id', 'DESC')
            ->limit(4)->get()->getResultArray();

        $price = 'Rp' . number_format((int) $p['price'], 0, ',', '.');

        return view('produk/show', [
            'title'  => $p['name'] . ' — ' . $p['m_name'] . ' — ARUNA',
            'p'      => $p,
            'others' => $others,
            'wa'     => $this->waLink($p['m_phone'], 'Halo ' . $p['m_name'] . ', saya mau pesan ' . $p['name'] . ' (' . $price . ') yang saya lihat di ARUNA.'),
            'waAsk'  => $this->waLink($p['m_phone'], 'Halo ' . $p['m_name'] . ', saya lihat usaha Anda di ARUNA.'),
        ]);
    }
}