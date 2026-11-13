<?php

namespace Database\Seeders;

use App\Models\DataSource;
use App\Models\NavigationItem;
use App\Models\PageAccessAccount;
use App\Models\PageAccessSetting;
use App\Models\ProgressItem;
use App\Models\Section;
use App\Models\SiteSetting;
use App\Models\StatCard;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Default Admin User
        User::updateOrCreate(
            ['email' => 'admin@pln.co.id'],
            [
                'name' => 'Administrator PLN UPT Manado',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Seed Site Settings
        $settings = [
            ['key' => 'site_title', 'value' => 'DASHBOARD KINERJA — UPT MANADO', 'group' => 'general', 'type' => 'text', 'label' => 'Judul Website'],
            ['key' => 'site_subtitle', 'value' => 'PT PLN (Persero) UPT Manado', 'group' => 'general', 'type' => 'text', 'label' => 'Sub Judul'],
            ['key' => 'hero_badge_text', 'value' => '● LIVE — Update:', 'group' => 'hero', 'type' => 'text', 'label' => 'Teks Badge Hero'],
            ['key' => 'hero_logo', 'value' => 'Logo_UPT_Manado.png', 'group' => 'branding', 'type' => 'image', 'label' => 'Logo Hero UPT'],
            ['key' => 'pln_logo', 'value' => 'PLN_White.png', 'group' => 'branding', 'type' => 'image', 'label' => 'Logo PLN Header'],
            ['key' => 'footer_text', 'value' => '© 2026 PT PLN (Persero) UPT Manado — Dashboard Kinerja Transmisi. All Rights Reserved.', 'group' => 'footer', 'type' => 'text', 'label' => 'Teks Footer'],
            ['key' => 'enable_live_clock', 'value' => '1', 'group' => 'hero', 'type' => 'boolean', 'label' => 'Aktifkan Jam Live'],
            ['key' => 'default_theme', 'value' => 'light', 'group' => 'general', 'type' => 'text', 'label' => 'Tema Default (light/dark)'],
        ];

        foreach ($settings as $s) {
            SiteSetting::updateOrCreate(['key' => $s['key']], $s);
        }

        // 3. Seed Navigation Items
        $navs = [
            ['label' => 'Home', 'url' => '/', 'icon' => 'home', 'order' => 1, 'is_active' => true],
            ['label' => 'Kinerja Unit', 'url' => '/kinerja-transmisi', 'icon' => 'activity', 'order' => 2, 'is_active' => true],
            ['label' => 'Anggaran Unit', 'url' => '/anggaran', 'icon' => 'dollar-sign', 'order' => 3, 'is_active' => true],
            ['label' => 'Aset', 'url' => '/aset', 'icon' => 'database', 'order' => 4, 'is_active' => true],
            ['label' => 'AHI', 'url' => '/ahi', 'icon' => 'shield', 'order' => 5, 'is_active' => true],
            ['label' => 'Common Enemy', 'url' => '/common-enemy', 'icon' => 'alert-triangle', 'order' => 6, 'is_active' => true],
            ['label' => 'Program Anti Blackout', 'url' => '/abo', 'icon' => 'zap', 'order' => 7, 'is_active' => true],
            ['label' => 'Konstruksi & Penyaluran', 'url' => '/konstruksi-penyaluran', 'icon' => 'truck', 'order' => 8, 'is_active' => true],
            ['label' => 'KKU', 'url' => '/kku', 'icon' => 'check-circle', 'order' => 9, 'is_active' => true],
        ];

        foreach ($navs as $nav) {
            NavigationItem::updateOrCreate(['label' => $nav['label']], $nav);
        }

        // 4. Seed Data Sources (Google Sheets CSV endpoints)
        $dataSources = [
            [
                'name' => 'Data Kinerja Unit (Indikator KPI & PI Transmisi)',
                'key' => 'kinerja_transmisi_csv',
                'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ7Ovm3gLoamwHFdoj8FI_bDn4peGyKvtPDJzHUIjAXMj_bzO_QVybM7I3nzVTpAxhVoz-yOi8OOumV/pub?output=csv',
                'description' => 'Data utama indikator KPI & PI Kinerja Unit/Transmisi beserta status capaian per ULTG.',
            ],
            [
                'name' => 'Data NKO (Progress Kinerja UPT)',
                'key' => 'nko_csv',
                'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSsiPTUoc4DRY6O_NLcn44tskrhiaIo6HQ0NPkl9N26ZnJYuZBSLX0zW8wawz_QyfypipvzPslRCyDV/pub?gid=1211605670&single=true&output=csv',
                'description' => 'Data capaian NKO bulanan, bobot nilai 110%, dan gap point.',
            ],
            [
                'name' => 'Data AHI Rekap',
                'key' => 'ahi_csv',
                'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTp0iLO9oj0vLgBy8cSQghkV6DtmKxFnoJuvIlyenhYtOcRLBpVQYsogjV5uNApZb0E_YbO85QidQkn/pub?output=csv',
                'description' => 'Rekapitulasi Health Index peralatan (MTU, Proteksi, IL3 Power Inspect).',
            ],
            [
                'name' => 'Data Kondisi Jaringan Tower',
                'key' => 'tower_kondisi_csv',
                'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTp0iLO9oj0vLgBy8cSQghkV6DtmKxFnoJuvIlyenhYtOcRLBpVQYsogjV5uNApZb0E_YbO85QidQkn/pub?gid=1948332076&single=true&output=csv',
                'description' => 'Resume kondisi per tower transmisi (Normal, Waspada, Kritis).',
            ],
            [
                'name' => 'Data Ringkasan Aset UPT',
                'key' => 'asset_csv',
                'source_type' => 'file',
                'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ7Ovm3gLoamwHFdoj8FI_bDn4peGyKvtPDJzHUIjAXMj_bzO_QVybM7I3nzVTpAxhVoz-yOi8OOumV/pub?gid=264440244&single=true&output=csv',
                'file_path' => 'asset-csv_1792389502.csv',
                'description' => 'Ringkasan jumlah GI, trafo daya, panjang kms, tower, sirkit.',
            ],
            [
                'name' => 'Data Koordinat & Marker Gardu Induk',
                'key' => 'gi_csv',
                'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTp0iLO9oj0vLgBy8cSQghkV6DtmKxFnoJuvIlyenhYtOcRLBpVQYsogjV5uNApZb0E_YbO85QidQkn/pub?gid=1464257596&single=true&output=csv',
                'description' => 'Daftar nama, koordinat GPS, ULTG, dan tegangan Gardu Induk untuk peta.',
            ],
            [
                'name' => 'Data Common Enemy',
                'key' => 'common_enemy_csv',
                'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSYXWVwCN8M7YvczPXdJ_0YpYTM8IAQHsXHdzWypCZiPOXkAx0nBG2JtMNYFu6YUTosQfU1HgCcc4Ue/pub?gid=408872963&single=true&output=csv',
                'description' => 'Data stream dan program kerja Common Enemy per komponen.',
            ],
            [
                'name' => 'Data Program Anti Blackout (ABO)',
                'key' => 'anti_blackout_csv',
                'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSYXWVwCN8M7YvczPXdJ_0YpYTM8IAQHsXHdzWypCZiPOXkAx0nBG2JtMNYFu6YUTosQfU1HgCcc4Ue/pub?gid=1190506631&single=true&output=csv',
                'description' => 'Data Sub Initiative program Anti Blackout (Jaringan, GI, Proteksi).',
            ],
            [
                'name' => 'Data Kinerja Keuangan & Umum (KKU)',
                'key' => 'kku_csv',
                'source_type' => 'file',
                'url' => '',
                'file_path' => 'contoh_template_kku.csv',
                'description' => 'Data realisasi dan tindak lanjut Kinerja Keuangan & Umum (KKU).',
            ],
            [
                'name' => 'Data Anggaran Unit (Investasi & Operasi)',
                'key' => 'anggaran_csv',
                'source_type' => 'url',
                'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRx2dxv5UCa5R84BkO9cOzfUfXZ1Yr_fBTDfC_Bxn5fvXpsk6Gt2QrrAWdO_MrsIA/pub?output=csv',
                'description' => 'Data penyerapan anggaran investasi dan operasi UPT Manado.',
            ],
        ];

        foreach ($dataSources as $ds) {
            DataSource::updateOrCreate(['key' => $ds['key']], $ds);
        }

        // 5. Seed Sections
        $sec1 = Section::updateOrCreate(
            ['slug' => 'kinerja-unit'],
            [
                'page' => 'home',
                'title' => '1. Ringkasan Kinerja Unit (NKO)',
                'description' => 'Capaian Nilai Kinerja Organisasi (NKO) periode bulanan UPT Manado.',
                'order' => 1,
                'is_visible' => true,
            ]
        );

        $sec2 = Section::updateOrCreate(
            ['slug' => 'aset'],
            [
                'page' => 'home',
                'title' => '2. Ringkasan Aset UPT Manado',
                'description' => 'Pemetaan GIS dan statistik aset transmisi di wilayah Sulut dan Gorontalo.',
                'order' => 2,
                'is_visible' => true,
            ]
        );

        $sec3 = Section::updateOrCreate(
            ['slug' => 'ahi'],
            [
                'page' => 'home',
                'title' => '3. Ringkasan Health Index Peralatan (AHI)',
                'description' => 'Kondisi kesehatan MTU, Proteksi (Relay), Jaringan, dan inspeksi IL3.',
                'order' => 3,
                'is_visible' => true,
            ]
        );

        $sec4 = Section::updateOrCreate(
            ['slug' => 'common-enemy'],
            [
                'page' => 'home',
                'title' => '4. Ringkasan Common Enemy',
                'description' => 'Progres penanganan anomali dan keandalan sistem per stream.',
                'order' => 4,
                'is_visible' => true,
            ]
        );

        $sec5 = Section::updateOrCreate(
            ['slug' => 'anti-blackout'],
            [
                'page' => 'home',
                'title' => '5. Ringkasan Program Anti Blackout',
                'description' => 'Inisiatif mitigasi gangguan meluas pada Transmisi, Gardu Induk, dan Proteksi.',
                'order' => 5,
                'is_visible' => true,
            ]
        );

        $sec6 = Section::updateOrCreate(
            ['slug' => 'konstruksi'],
            [
                'page' => 'home',
                'title' => '6. Ringkasan Konstruksi dan Penyaluran',
                'description' => 'Kemajuan konstruksi fisik proyek ketenagalistrikan dan COD.',
                'order' => 6,
                'is_visible' => true,
            ]
        );

        $sec7 = Section::updateOrCreate(
            ['slug' => 'kku'],
            [
                'page' => 'home',
                'title' => '7. Ringkasan KKU',
                'description' => 'Realisasi dan status tindak lanjut Kinerja Keuangan & Umum.',
                'order' => 7,
                'is_visible' => true,
            ]
        );

        // 6. Seed Stat Cards for Section 1 (Kinerja Unit / NKO)
        $nkoDs = DataSource::where('key', 'nko_csv')->first();
        $nkoCards = [
            ['title' => 'NKO Bulan Berjalan', 'value' => '96,26', 'unit' => 'Poin', 'footer_text' => 'Realisasi NKO Bulan Berjalan', 'order' => 1, 'css_class' => 'valNko', 'data_source_id' => $nkoDs?->id, 'csv_key' => 'nko_csv', 'csv_search_query' => 'bobot nilai', 'csv_formula' => 'column_header'],
            ['title' => 'NKO Max 110%', 'value' => '101,35', 'unit' => 'Poin', 'footer_text' => 'Batas maksimal bobot 110%', 'order' => 2, 'css_class' => 'valNkoCap', 'data_source_id' => $nkoDs?->id, 'csv_key' => 'nko_csv', 'csv_search_query' => 'bobot nilai 110', 'csv_formula' => 'column_header'],
            ['title' => 'Gap Point', 'value' => '3,74', 'unit' => 'Poin', 'footer_text' => 'Selisih pencapaian terhadap target', 'order' => 3, 'css_class' => 'valGap', 'data_source_id' => $nkoDs?->id, 'csv_key' => 'nko_csv', 'csv_search_query' => 'gap point', 'csv_formula' => 'column_header'],
        ];
        foreach ($nkoCards as $c) {
            StatCard::updateOrCreate(['section_id' => $sec1->id, 'title' => $c['title']], array_merge($c, ['section_id' => $sec1->id]));
        }

        // 7. Seed Stat Cards for Section 2 (Assets)
        $assetDs = DataSource::where('key', 'asset_csv')->first();
        $assetCards = [
            ['title' => 'Jumlah Gardu Induk', 'value' => '37', 'unit' => 'Unit', 'icon' => '🏢', 'order' => 1, 'css_class' => 'cardGI', 'data_source_id' => $assetDs?->id, 'csv_key' => 'asset_csv', 'csv_search_query' => 'Num of Sustation (unit)', 'csv_formula' => 'asset_param'],
            ['title' => 'Jumlah Trafo Daya', 'value' => '57', 'unit' => 'Unit', 'icon' => '⚡', 'order' => 2, 'css_class' => 'cardTrafo', 'data_source_id' => $assetDs?->id, 'csv_key' => 'asset_csv', 'csv_search_query' => 'Total of Transformer (unit)', 'csv_formula' => 'asset_param'],
            ['title' => 'Panjang Transmisi', 'value' => '2.233,49', 'unit' => 'kms', 'icon' => '🔌', 'order' => 3, 'css_class' => 'cardPanjang', 'data_source_id' => $assetDs?->id, 'csv_key' => 'asset_csv', 'csv_search_query' => 'Length of Circuit (kms)', 'csv_formula' => 'asset_param'],
            ['title' => 'Titik Tower Transmisi', 'value' => '3.423', 'unit' => 'Tower', 'icon' => '🗼', 'order' => 4, 'css_class' => 'cardTower', 'data_source_id' => $assetDs?->id, 'csv_key' => 'asset_csv', 'csv_search_query' => 'Num of Tower (tower)', 'csv_formula' => 'asset_param'],
            ['title' => 'Jumlah Sirkit Transmisi', 'value' => '81', 'unit' => 'Sirkit', 'icon' => '📡', 'order' => 5, 'css_class' => 'cardJalur', 'data_source_id' => $assetDs?->id, 'csv_key' => 'asset_csv', 'csv_search_query' => 'Total Circuit by Age (circuit)', 'csv_formula' => 'asset_param'],
        ];
        foreach ($assetCards as $c) {
            StatCard::updateOrCreate(['section_id' => $sec2->id, 'title' => $c['title']], array_merge($c, ['section_id' => $sec2->id]));
        }

        // 8. Seed Stat Cards for Section 3 (AHI)
        $ahiDs = DataSource::where('key', 'ahi_csv')->first();
        $towerDs = DataSource::where('key', 'tower_kondisi_csv')->first();
        $ahiCards = [
            ['title' => 'Kondisi Peralatan Utama (MTU)', 'value' => '1.842', 'unit' => 'Unit Diperiksa', 'footer_text' => 'Menunggu sumber data...', 'order' => 1, 'css_class' => 'cardMtu', 'data_source_id' => $ahiDs?->id, 'csv_key' => 'ahi_csv', 'csv_search_query' => 'mtu', 'csv_formula' => 'auto'],
            ['title' => 'Kondisi Proteksi (Relay)', 'value' => '1.240', 'unit' => 'Unit Diperiksa', 'footer_text' => 'Menunggu sumber data...', 'order' => 2, 'css_class' => 'cardRelay', 'data_source_id' => $ahiDs?->id, 'csv_key' => 'ahi_csv', 'csv_search_query' => 'relay', 'csv_formula' => 'auto'],
            ['title' => 'Kondisi Jaringan (Tower)', 'value' => '3.453', 'unit' => 'Tower Dinilai', 'footer_text' => 'Menunggu sumber data...', 'order' => 3, 'css_class' => 'cardJaringan', 'data_source_id' => $towerDs?->id, 'csv_key' => 'tower_kondisi_csv', 'csv_search_query' => 'tower', 'csv_formula' => 'auto'],
            ['title' => 'IL-3 Power Inspect', 'value' => '92.4%', 'unit' => '%', 'footer_text' => 'Menunggu sumber data...', 'order' => 4, 'css_class' => 'cardIL3', 'data_source_id' => $ahiDs?->id, 'csv_key' => 'ahi_csv', 'csv_search_query' => 'il-3', 'csv_formula' => 'auto'],
        ];
        foreach ($ahiCards as $c) {
            StatCard::updateOrCreate(['section_id' => $sec3->id, 'title' => $c['title']], array_merge($c, ['section_id' => $sec3->id]));
        }

        // 9. Seed Stat Cards for Section 4 (Common Enemy)
        $ceDs = DataSource::where('key', 'common_enemy_csv')->first();
        $ceCards = [
            ['title' => 'Total Program Common Enemy', 'value' => '29', 'unit' => 'Program', 'footer_text' => 'Sasaran pohon kritis dekat ROW & titik rawan eksternal', 'order' => 1, 'css_class' => 'ceTotal', 'data_source_id' => $ceDs?->id, 'csv_key' => 'common_enemy_csv', 'csv_search_query' => 'total', 'csv_formula' => 'auto'],
            ['title' => 'Program On Target (≥100%)', 'value' => '20', 'unit' => 'Program', 'footer_text' => 'Capaian On Target dari total 29 program', 'order' => 2, 'css_class' => 'ceOnTarget', 'data_source_id' => $ceDs?->id, 'csv_key' => 'common_enemy_csv', 'csv_search_query' => 'on target', 'csv_formula' => 'auto'],
            ['title' => 'Program Perlu Perhatian (Late/Out)', 'value' => '9', 'unit' => 'Program', 'footer_text' => 'Program Late/Out memerlukan percepatan eksekusi', 'order' => 3, 'css_class' => 'ceLate', 'data_source_id' => $ceDs?->id, 'csv_key' => 'common_enemy_csv', 'csv_search_query' => 'late', 'csv_formula' => 'auto'],
        ];
        foreach ($ceCards as $c) {
            StatCard::updateOrCreate(['section_id' => $sec4->id, 'title' => $c['title']], array_merge($c, ['section_id' => $sec4->id]));
        }

        // 10. Seed Stat Cards for Section 5 (Program Anti Blackout)
        $aboDs = DataSource::where('key', 'anti_blackout_csv')->first();
        $aboCards = [
            ['title' => 'Inisiatif Jaringan Transmisi', 'value' => '154.3%', 'unit' => '%', 'footer_text' => 'Capaian rata-rata inisiatif transmisi', 'order' => 1, 'css_class' => 'aboJaringan', 'data_source_id' => $aboDs?->id, 'csv_key' => 'anti_blackout_csv', 'csv_search_query' => 'jaringan', 'csv_formula' => 'auto'],
            ['title' => 'Inisiatif Gardu Induk', 'value' => '99.6%', 'unit' => '%', 'footer_text' => 'Capaian rata-rata inisiatif gardu induk', 'order' => 2, 'css_class' => 'aboGI', 'data_source_id' => $aboDs?->id, 'csv_key' => 'anti_blackout_csv', 'csv_search_query' => 'gardu induk', 'csv_formula' => 'auto'],
            ['title' => 'Inisiatif Sistem Proteksi', 'value' => '80%', 'unit' => '%', 'footer_text' => 'Capaian rata-rata inisiatif sistem proteksi', 'order' => 3, 'css_class' => 'aboProteksi', 'data_source_id' => $aboDs?->id, 'csv_key' => 'anti_blackout_csv', 'csv_search_query' => 'proteksi', 'csv_formula' => 'auto'],
        ];
        foreach ($aboCards as $c) {
            StatCard::updateOrCreate(['section_id' => $sec5->id, 'title' => $c['title']], array_merge($c, ['section_id' => $sec5->id]));
        }

        // 11. Seed Stat Cards for Section 6 (Konstruksi)
        $konstrCards = [
            ['title' => 'Progres Konstruksi SUTT/GI', 'value' => '68%', 'unit' => '%', 'footer_text' => 'Penyelesaian proyek konstruksi jaringan transmisi & GI', 'order' => 1, 'css_class' => 'cardKonstruksiSutt', 'data_source_id' => null, 'csv_key' => '', 'csv_search_query' => '', 'csv_formula' => 'manual'],
            ['title' => 'Kesiapan Penyaluran (COD)', 'value' => '82%', 'unit' => '%', 'footer_text' => 'Kesiapan penyaluran tenaga listrik pembangkit baru', 'order' => 2, 'css_class' => 'cardKonstruksiCod', 'data_source_id' => null, 'csv_key' => '', 'csv_search_query' => '', 'csv_formula' => 'manual'],
            ['title' => 'Serah Terima Aset (STO)', 'value' => '45%', 'unit' => '%', 'footer_text' => 'Progres administrasi dan teknis STO', 'order' => 3, 'css_class' => 'cardKonstruksiSto', 'data_source_id' => null, 'csv_key' => '', 'csv_search_query' => '', 'csv_formula' => 'manual'],
        ];
        foreach ($konstrCards as $c) {
            StatCard::updateOrCreate(['section_id' => $sec6->id, 'title' => $c['title']], array_merge($c, ['section_id' => $sec6->id]));
        }

        // 12. Seed Stat Cards for Section 7 (KKU)
        $kkuDs = DataSource::where('key', 'kku_csv')->first();
        $kkuCards = [
            ['title' => 'Realisasi KKU Bulan Berjalan', 'value' => '96.8%', 'unit' => '%', 'footer_text' => 'Realisasi anggaran dan kepatuhan umum bulan berjalan', 'order' => 1, 'data_source_id' => $kkuDs?->id, 'csv_key' => 'kku_csv', 'csv_search_query' => 'Realisasi KKU Bulan Berjalan', 'csv_formula' => 'metric_row'],
            ['title' => 'Status Tindak Lanjut', 'value' => '100%', 'unit' => '%', 'footer_text' => 'Tindak lanjut rekomendasi auditor & manajemen', 'order' => 2, 'data_source_id' => $kkuDs?->id, 'csv_key' => 'kku_csv', 'csv_search_query' => 'Status Tindak Lanjut', 'csv_formula' => 'metric_row'],
            ['title' => 'Capaian Kumulatif', 'value' => '92.5%', 'unit' => '%', 'footer_text' => 'Akumulasi capaian kinerja keuangan & umum tahun 2026', 'order' => 3, 'data_source_id' => $kkuDs?->id, 'csv_key' => 'kku_csv', 'csv_search_query' => 'Capaian Kumulatif', 'csv_formula' => 'metric_row'],
        ];
        foreach ($kkuCards as $c) {
            StatCard::updateOrCreate(['section_id' => $sec7->id, 'title' => $c['title']], array_merge($c, ['section_id' => $sec7->id]));
        }

        // 8. Seed Progress Items for Section 6 (Konstruksi)
        $progress = [
            [
                'section_id' => $sec6->id,
                'title' => 'Progres Konstruksi SUTT/GI',
                'description' => 'Persentase penyelesaian proyek konstruksi jaringan transmisi & gardu induk yang sedang berjalan.',
                'icon' => '🏗️',
                'percentage' => 68.0,
                'order' => 1,
            ],
            [
                'section_id' => $sec6->id,
                'title' => 'Kesiapan Penyaluran (COD)',
                'description' => 'Kesiapan penyaluran tenaga listrik dari pembangkit baru menuju jaringan sistem transmisi Sulutgo.',
                'icon' => '🔗',
                'percentage' => 82.0,
                'order' => 2,
            ],
            [
                'section_id' => $sec6->id,
                'title' => 'Serah Terima Aset (STO)',
                'description' => 'Progres administrasi dan teknis serah terima operasi aset baru dari unit konstruksi ke unit transmisi.',
                'icon' => '📋',
                'percentage' => 45.0,
                'order' => 3,
            ],
        ];

        foreach ($progress as $p) {
            ProgressItem::updateOrCreate(
                ['section_id' => $sec6->id, 'title' => $p['title']],
                $p
            );
        }

        // 7. Seed Page Access Settings (Mode Proteksi Halaman)
        \App\Http\Controllers\Admin\PageAccessController::seedDefaultPages();

        // 8. Seed Default Personnel Account if not exists
        if (PageAccessAccount::count() === 0) {
            PageAccessAccount::create([
                'name' => 'Admin Monitoring UPT',
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'allowed_pages' => ['*'],
                'is_active' => true,
                'notes' => 'Akun personil default dengan akses ke semua halaman terbatas',
            ]);
        }
    }
}
