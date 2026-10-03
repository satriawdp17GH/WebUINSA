<?php

/**
 * ARUNA — app/Helpers/aruna_helper.php
 * Muat dengan helper('aruna') atau daftarkan di BaseController::$helpers = ['url', 'aruna'].
 */

if (! function_exists('fmt_rupiah')) {
    function fmt_rupiah(int|float $n): string
    {
        return 'Rp' . number_format($n, 0, ',', '.');
    }
}

if (! function_exists('fmt_km')) {
    function fmt_km(float $km): string
    {
        return number_format($km, 1, ',', '.') . ' km';
    }
}

if (! function_exists('fmt_rating')) {
    function fmt_rating(float $r): string
    {
        return number_format($r, 1, ',', '.');
    }
}

if (! function_exists('aruna_media')) {
    /**
     * Foto jika ada (file di public/uploads/), jika tidak tampilkan icon dari library (Bootstrap Icons/SVG) atau emoji fallback.
     */
    function aruna_media(?string $photo, ?string $icon, string $alt = ''): string
    {
        if ($photo) {
            return '<img src="' . esc(base_url('uploads/' . ltrim($photo, '/')), 'attr') . '" alt="'
                . esc($alt, 'attr') . '" loading="lazy" decoding="async">';
        }

        $icon = (string) ($icon ?? 'bi-bag');

        // Jika class Bootstrap Icons (misal: 'bi-shop' atau 'bi bi-shop')
        if (str_starts_with($icon, 'bi-') || str_starts_with($icon, 'bi ')) {
            $cls = str_starts_with($icon, 'bi ') ? $icon : 'bi ' . $icon;
            return '<span class="emo" aria-hidden="true"><i class="' . esc($cls, 'attr') . '"></i></span>';
        }

        // Jika string sudah berupa elemen SVG
        if (str_starts_with($icon, '<svg')) {
            return '<span class="emo" aria-hidden="true">' . $icon . '</span>';
        }

        // Cek jika merupakan icon SVG yang terdaftar di aruna_icon
        $svg = aruna_icon($icon, 32);
        if ($svg !== '') {
            return '<span class="emo" aria-hidden="true">' . $svg . '</span>';
        }

        return '<span class="emo" aria-hidden="true">' . esc($icon) . '</span>';
    }
}

if (! function_exists('aruna_logo')) {
    function aruna_logo(int $size = 32): string
    {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 32 32" fill="none" aria-hidden="true">'
            . '<path d="M5 27 16 5l11 22" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>'
            . '<path class="wave" d="M9 21c4-5 7-1 9-3s3-3 5-4" stroke="#f28a2e" stroke-width="3.4" stroke-linecap="round"/></svg>';
    }
}

if (! function_exists('aruna_icon')) {
    function aruna_icon(string $name, int $size = 22): string
    {
        static $p = [
            'search'  => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
            'heart'   => '<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>',
            'bag'     => '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>',
            'user'    => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
            'home'    => '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/>',
            'compass' => '<circle cx="12" cy="12" r="10"/><path d="m16.24 7.76-2.12 6.36-6.36 2.12 2.12-6.36 6.36-2.12z"/>',
            'receipt' => '<path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 17.5v-11"/>',
            'pin'     => '<path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
            'plus'    => '<path d="M12 5v14M5 12h14"/>',
            'minus'   => '<path d="M5 12h14"/>',
            'check'   => '<path d="m5 12 5 5L20 7"/>',
            'arrow'   => '<path d="M5 12h14M13 6l6 6-6 6"/>',
            'close'   => '<path d="M18 6 6 18M6 6l12 12"/>',
            'chevron' => '<path d="m6 9 6 6 6-6"/>',
            'left'    => '<path d="m15 18-6-6 6-6"/>',
            'right'   => '<path d="m9 18 6-6-6-6"/>',
            'clock'   => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
            'card'    => '<rect width="20" height="14" x="2" y="5" rx="2"/><path d="M2 10h20"/>',
            'truck'   => '<path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/>',
            'star'    => '<path d="M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1z"/>',
            'location' => '<path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
            'store' => '<path d="M3 10h18"/><path d="M5 10v10h14V10"/><path d="M4 10 6 4h12l2 6"/><path d="M8 20v-5h8v5"/>',
            'mail' => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-10 6L2 7"/>',
            'whatsapp' => '<path d="M20 11.5a8.5 8.5 0 0 1-12.7 7.4L3 20l1.2-4.1A8.5 8.5 0 1 1 20 11.5Z"/>',
            'phone' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.78.62 2.63a2 2 0 0 1-.45 2.11L8 9.73a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.85.29 1.73.5 2.63.62A2 2 0 0 1 22 16.92Z"/>',
            'shop' => '<path d="M3 10h18"/><path d="M5 10v10h14V10"/><path d="M4 10 6 4h12l2 6"/><path d="M8 20v-5h8v5"/>',
            'map' => '<path d="m9 18-6 3V6l6-3 6 3 6-3v15l-6 3-6-3Z"/><path d="M9 3v15"/><path d="M15 6v15"/>',
        ];

        if (! isset($p[$name])) {
            return '';
        }

        $solid = $name === 'star';

        return '<svg class="ic ic-' . $name . '" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="'
            . ($solid ? 'currentColor' : 'none') . '" stroke="' . ($solid ? 'none' : 'currentColor')
            . '" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">'
            . $p[$name] . '</svg>';
    }
}