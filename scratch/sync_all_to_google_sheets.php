<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\DataSource;

$sources = [
    'nko_csv' => [
        'name' => 'Data NKO (Progress Kinerja UPT)',
        'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSsiPTUoc4DRY6O_NLcn44tskrhiaIo6HQ0NPkl9N26ZnJYuZBSLX0zW8wawz_QyfypipvzPslRCyDV/pub?gid=1211605670&single=true&output=csv',
        'description' => 'Sumber data Google Spreadsheet resmi untuk indikator NKO bulanan UPT Manado (Sheet Progress Kinerja UPT)',
    ],
    'ahi_csv' => [
        'name' => 'Data AHI Rekap',
        'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTp0iLO9oj0vLgBy8cSQghkV6DtmKxFnoJuvIlyenhYtOcRLBpVQYsogjV5uNApZb0E_YbO85QidQkn/pub?output=csv',
        'description' => 'Sumber data Google Spreadsheet resmi untuk Anomali Health Index (AHI)',
    ],
    'tower_kondisi_csv' => [
        'name' => 'Data Kondisi Jaringan Tower',
        'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTp0iLO9oj0vLgBy8cSQghkV6DtmKxFnoJuvIlyenhYtOcRLBpVQYsogjV5uNApZb0E_YbO85QidQkn/pub?gid=1948332076&single=true&output=csv',
        'description' => 'Sumber data Google Spreadsheet resmi untuk kondisi fisik dan anomali tower transmisi',
    ],
    'asset_csv' => [
        'name' => 'Data Ringkasan Aset UPT',
        'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ7Ovm3gLoamwHFdoj8FI_bDn4peGyKvtPDJzHUIjAXMj_bzO_QVybM7I3nzVTpAxhVoz-yOi8OOumV/pub?gid=264440244&single=true&output=csv',
        'description' => 'Sumber data Google Spreadsheet resmi untuk ringkasan aset UPT Manado (GI, Trafo, SUTT, Bay)',
    ],
    'gi_csv' => [
        'name' => 'Data Koordinat & Marker Gardu Induk',
        'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTp0iLO9oj0vLgBy8cSQghkV6DtmKxFnoJuvIlyenhYtOcRLBpVQYsogjV5uNApZb0E_YbO85QidQkn/pub?gid=1464257596&single=true&output=csv',
        'description' => 'Sumber data Google Spreadsheet resmi koordinat pemetaan Gardu Induk Suluttenggo',
    ],
    'common_enemy_csv' => [
        'name' => 'Data Common Enemy',
        'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSYXWVwCN8M7YvczPXdJ_0YpYTM8IAQHsXHdzWypCZiPOXkAx0nBG2JtMNYFu6YUTosQfU1HgCcc4Ue/pub?gid=408872963&single=true&output=csv',
        'description' => 'Sumber data Google Spreadsheet resmi untuk program kerja Common Enemy transmisi',
    ],
    'anti_blackout_csv' => [
        'name' => 'Data Program Anti Blackout (ABO)',
        'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSYXWVwCN8M7YvczPXdJ_0YpYTM8IAQHsXHdzWypCZiPOXkAx0nBG2JtMNYFu6YUTosQfU1HgCcc4Ue/pub?gid=1190506631&single=true&output=csv',
        'description' => 'Sumber data Google Spreadsheet resmi untuk program kerja Anti Blackout (ABO)',
    ],
    'anggaran_csv' => [
        'name' => 'Data Anggaran Unit (Investasi & Operasi)',
        'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRx2dxv5UCa5R84BkO9cOzfUfXZ1Yr_fBTDfC_Bxn5fvXpsk6Gt2QrrAWdO_MrsIA/pub?output=csv',
        'description' => 'Sumber data Google Spreadsheet resmi untuk monitoring realisasi anggaran investasi & operasi',
    ],
    'kinerja_transmisi_csv' => [
        'name' => 'Data Kinerja Unit (Indikator KPI & PI Transmisi)',
        'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ7Ovm3gLoamwHFdoj8FI_bDn4peGyKvtPDJzHUIjAXMj_bzO_QVybM7I3nzVTpAxhVoz-yOi8OOumV/pub?output=csv',
        'description' => 'Sumber data Google Spreadsheet resmi indikator utama kinerja transmisi (Main Sheet)',
    ],
];

echo "Updating all DataSources in database to live Google Spreadsheet URLs...\n";

foreach ($sources as $key => $data) {
    $ds = DataSource::firstOrNew(['key' => $key]);
    $ds->name = $data['name'];
    $ds->source_type = 'url';
    $ds->url = $data['url'];
    $ds->file_path = null; // Clear local uploaded file reference
    $ds->description = $data['description'];
    $ds->is_active = true;
    $ds->save();

    echo "  [UPDATED] {$key} => {$ds->effective_url}\n";
}

echo "All DataSources successfully updated to live Google Spreadsheet URLs!\n";
