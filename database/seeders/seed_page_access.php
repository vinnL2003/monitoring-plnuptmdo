<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PageAccessSetting;
use App\Models\PageAccessAccount;
use Illuminate\Support\Facades\Hash;

// 1. Seed Page Access Settings
$pages = [
    [
        'page_slug' => 'anggaran',
        'page_name' => 'Anggaran Unit',
        'page_url' => '/anggaran',
        'icon' => '💰',
        'is_restricted' => true, // default: restricted on for anggaran
        'description' => 'Monitoring RKAU, SKKI, SKKO, dan PRK Investasi / Operasi UPT Manado',
    ],
    [
        'page_slug' => 'kinerja-transmisi',
        'page_name' => 'Kinerja Unit / Transmisi',
        'page_url' => '/kinerja-transmisi',
        'icon' => '⚡',
        'is_restricted' => false,
        'description' => 'Kinerja transmisi, frekuensi gangguan, dan real-time monitoring',
    ],
    [
        'page_slug' => 'aset',
        'page_name' => 'Aset Transmisi',
        'page_url' => '/aset',
        'icon' => '🏭',
        'is_restricted' => false,
        'description' => 'Peta Gardu Induk, tower transmisi, dan inventaris aset UPT',
    ],
    [
        'page_slug' => 'ahi',
        'page_name' => 'Asset Health Index (AHI)',
        'page_url' => '/ahi',
        'icon' => '🩺',
        'is_restricted' => false,
        'description' => 'Indeks kesehatan trafo dan peralatan bay',
    ],
    [
        'page_slug' => 'common-enemy',
        'page_name' => 'Common Enemy',
        'page_url' => '/common-enemy',
        'icon' => '🎯',
        'is_restricted' => false,
        'description' => 'Monitoring mitigasi titik rawan dan pohon',
    ],
    [
        'page_slug' => 'abo',
        'page_name' => 'Program Anti Blackout (ABO)',
        'page_url' => '/abo',
        'icon' => '🛡️',
        'is_restricted' => false,
        'description' => 'Kesiapan skema pertahanan sistem kelistrikan UPT',
    ],
    [
        'page_slug' => 'konstruksi-penyaluran',
        'page_name' => 'Konstruksi & Penyaluran',
        'page_url' => '/konstruksi-penyaluran',
        'icon' => '🏗️',
        'is_restricted' => false,
        'description' => 'Proyek transmisi baru, rekonduktoring, dan progres COD',
    ],
    [
        'page_slug' => 'kku',
        'page_name' => 'Keuangan, Komunikasi & Umum (KKU)',
        'page_url' => '/kku',
        'icon' => '👥',
        'is_restricted' => false,
        'description' => 'Pengelolaan SDM, TJSL, sertifikasi tanah, dan administrasi umum',
    ],
];

foreach ($pages as $p) {
    PageAccessSetting::updateOrCreate(
        ['page_slug' => $p['page_slug']],
        $p
    );
}

// 2. Seed Initial Personnel Accounts with encrypted bcrypt passwords
$accounts = [
    [
        'name' => 'Administrator Sistem',
        'username' => 'admin',
        'password' => Hash::make('admin'),
        'allowed_pages' => ['*'], // Akses ke semua halaman terbatas
        'is_active' => true,
        'notes' => 'Akun personil default dengan hak akses penuh ke semua halaman terbatas',
    ],
    [
        'name' => 'Personil Anggaran (92141105ZY)',
        'username' => '92141105ZY',
        'password' => Hash::make('Manado28'),
        'allowed_pages' => ['anggaran'],
        'is_active' => true,
        'notes' => 'Akses staf anggaran UPT Manado',
    ],
    [
        'name' => 'Arista (Staf Anggaran)',
        'username' => 'Arista',
        'password' => Hash::make('Arista'),
        'allowed_pages' => ['anggaran'],
        'is_active' => true,
        'notes' => 'Akses staf pengelola anggaran',
    ],
];

foreach ($accounts as $acc) {
    PageAccessAccount::updateOrCreate(
        ['username' => $acc['username']],
        $acc
    );
}

echo "Seeding page_access_settings and page_access_accounts completed successfully.\n";
