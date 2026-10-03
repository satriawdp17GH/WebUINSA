<?php

namespace App\Controllers;

use App\Controllers\Traits\PublicListing;

/**
 * Publik:
 *  GET gerobak -> index (khusus gerobak keliling)
 *  GET gerobak/(:segment) -> show (detail gerobak)
 */
class Gerobak extends BaseController
{
    use PublicListing;

    public function index()
    {
        return $this->listMerchants('gerobak');
    }

    public function show(string $slug)
    {
        return $this->showMerchant($slug, 'gerobak');
    }
}