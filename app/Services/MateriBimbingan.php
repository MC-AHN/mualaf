<?php

namespace App\Services;

class MateriBimbingan
{
    public static function list(): array
    {
        return [
            'aqidah_syahadat' => 'Pondasi Aqidah & Makna Dua Kalimat Syahadat',
            'thaharah_wudhu' => 'Tata Cara Thaharah, Wudhu & Mandi Wajib',
            'praktek_shalat' => 'Gerakan & Bacaan Shalat Fardhu',
            'hafalan_alfatihah' => 'Hafalan Surah Al-Fatihah & Surah Pendek',
            'iqra_bacaan' => 'Pengenalan Huruf Hijaiyah & Dasar Iqra',
            'fiqh_muamalah' => 'Dasar Akhlaq & Prinsip Makanan Halal/Haram',
        ];
    }
}