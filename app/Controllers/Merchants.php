<?php

namespace App\Controllers;

use App\Controllers\Traits\PublicListing;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Publik:
 *  GET jelajahi              -> index (khusus UMKM / type 'toko')
 *  GET kategori/(:segment)   -> category
 *  GET umkm/(:segment)       -> show (detail UMKM)
 */
class Merchants extends BaseController
{
    use PublicListing;

    public function index()
    {
        return $this->listMerchants('toko');
    }

    public function category(string $slug)
    {
        $cat = db_connect()->table('categories')->where('slug', $slug)->where('is_active', 1)->get()->getRowArray();
        if (! $cat) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $this->listMerchants('toko', $cat['slug']);
    }

    public function show(string $slug)
    {
        return $this->showMerchant($slug, 'toko');
    }
}