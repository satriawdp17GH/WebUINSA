<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function about()
    {
        return view('pages/tentang');
    }

    public function faq()
    {
        return view('pages/faq');
    }

    public function privacy()
    {
        return view('pages/kebijakan_privasi');
    }

    public function terms()
    {
        return view('pages/syarat_ketentuan');
    }

    public function contact()
    {
        return view('pages/hubungi_kami');
    }

    public function sendContact()
    {
        // Untuk sementara
        return redirect()->to('/hubungi-kami')
            ->with('success', 'Pesan berhasil dikirim.');
    }
}