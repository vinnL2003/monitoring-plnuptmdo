<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataSource;
use App\Models\StatCard;
use App\Services\CsvSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PageDataSyncController extends Controller
{
    protected CsvSyncService $syncService;

    public function __construct(CsvSyncService $syncService)
    {
        $this->syncService = $syncService;
    }

    /**
     * Definisi katalog halaman website dan data source terkait
     */
    public function getPageCatalog(): array
    {
        return [
            [
                'slug' => 'home',
                'title' => 'Beranda / Dashboard Utama',
                'route_name' => 'home',
                'url' => '/',
                'icon' => '🏠',
                'badge' => 'Dashboard',
                'description' => 'Ringkasan Kinerja Organisasi (NKO), capaian bobot 110%, gap point, ringkasan aset transmisi, dan peta Gardu Induk GIS.',
                'data_source_keys' => ['nko_csv', 'asset_csv', 'gi_csv'],
            ],
            [
                'slug' => 'kinerja-transmisi',
                'title' => 'Kinerja Unit / Transmisi',
                'route_name' => 'kinerja-transmisi',
                'url' => '/kinerja-transmisi',
                'icon' => '⚡',
                'badge' => 'KPI & PI',
                'description' => 'Indikator Utama Transmisi (SAIDI, SAIFI, TLO, ENS, Trip) beserta status capaian per ULTG.',
                'data_source_keys' => ['kinerja_transmisi_csv'],
            ],
            [
                'slug' => 'anggaran',
                'title' => 'Anggaran Unit (Investasi & Operasi)',
                'route_name' => 'anggaran',
                'url' => '/anggaran',
                'icon' => '💰',
                'badge' => 'Keuangan',
                'description' => 'Alokasi Pagu, Realisasi Keuangan, Prognosa, SKKI, SKKO, dan PRK Investasi/Operasi UPT Manado.',
                'data_source_keys' => ['anggaran_csv'],
            ],
            [
                'slug' => 'aset',
                'title' => 'Aset Transmisi & Pemetaan GIS',
                'route_name' => 'aset',
                'url' => '/aset',
                'icon' => '🗺️',
                'badge' => 'Aset & GIS',
                'description' => 'Rekapitulasi kuantitas Gardu Induk, Trafo Daya, Panjang Penghantar (kms), Tower, serta titik koordinat GPS GI.',
                'data_source_keys' => ['asset_csv', 'gi_csv', 'tower_kondisi_csv'],
            ],
            [
                'slug' => 'ahi',
                'title' => 'Asset Health Index (AHI)',
                'route_name' => 'ahi',
                'url' => '/ahi',
                'icon' => '🩺',
                'badge' => 'Health Index',
                'description' => 'Kondisi kesehatan peralatan utama (MTU), Proteksi (Relay), inspeksi IL3 Power Inspect, dan status tower.',
                'data_source_keys' => ['ahi_csv', 'tower_kondisi_csv'],
            ],
            [
                'slug' => 'common-enemy',
                'title' => 'Common Enemy (Titik Rawan Pohon)',
                'route_name' => 'common-enemy',
                'url' => '/common-enemy',
                'icon' => '🌲',
                'badge' => 'Keandalan',
                'description' => 'Pohon kritis dekat ROW, titik rawan gangguan eksternal, dan matriks tindak lanjut pemangkasan.',
                'data_source_keys' => ['common_enemy_csv'],
            ],
            [
                'slug' => 'abo',
                'title' => 'Program Anti Blackout (ABO)',
                'route_name' => 'abo',
                'url' => '/abo',
                'icon' => '🛡️',
                'badge' => 'Sistem Grid',
                'description' => 'Sub-Initiative program pencegahan padam meluas (Jaringan, Gardu Induk, dan Sistem Proteksi).',
                'data_source_keys' => ['anti_blackout_csv'],
            ],
            [
                'slug' => 'kku',
                'title' => 'Keuangan, Komunikasi & Umum (KKU)',
                'route_name' => 'kku',
                'url' => '/kku',
                'icon' => '📋',
                'badge' => 'KKU Support',
                'description' => 'Target, realisasi, dan program kerja berkala bidang Keuangan, Komunikasi, dan Umum UPT Manado.',
                'data_source_keys' => ['kku_csv'],
            ],
            [
                'slug' => 'konstruksi-penyaluran',
                'title' => 'Konstruksi & Penyaluran',
                'route_name' => 'konstruksi-penyaluran',
                'url' => '/konstruksi-penyaluran',
                'icon' => '🏗️',
                'badge' => 'Proyek COD',
                'description' => 'Progres fisik proyek transmisi baru, Commercial Operation Date (COD), dan Serah Terima Operasi (STO).',
                'data_source_keys' => [],
            ],
        ];
    }

    /**
     * Tampilan daftar seluruh halaman beserta sumber data yang terhubung
     */
    public function index()
    {
        $allDataSources = DataSource::all()->keyBy('key');
        $catalog = $this->getPageCatalog();

        $pages = [];
        foreach ($catalog as $item) {
            $linkedSources = [];
            foreach ($item['data_source_keys'] as $k) {
                if ($allDataSources->has($k)) {
                    $ds = $allDataSources->get($k);
                    $fileInfo = $this->getSourceFileInfo($ds);
                    $linkedSources[] = [
                        'model' => $ds,
                        'file_info' => $fileInfo,
                    ];
                }
            }

            $item['sources'] = $linkedSources;
            $pages[] = $item;
        }

        // Hitung ringkasan statistik
        $totalSources = $allDataSources->count();
        $fileModifiedSources = $allDataSources->where('source_type', 'file')->count();
        $urlSources = $allDataSources->where('source_type', 'url')->count();

        return view('admin.page_data.index', compact('pages', 'allDataSources', 'totalSources', 'fileModifiedSources', 'urlSources'));
    }

    /**
     * Buka editor spreadsheet interaktif untuk suatu DataSource
     */
    public function edit(string $key)
    {
        $dataSource = DataSource::where('key', $key)->firstOrFail();

        // Cari tahu halaman mana saja yang memakai sumber data ini
        $pagesUsingThis = [];
        foreach ($this->getPageCatalog() as $page) {
            if (in_array($key, $page['data_source_keys'])) {
                $pagesUsingThis[] = $page;
            }
        }

        $fileInfo = $this->getSourceFileInfo($dataSource);

        // Ambil data CSV mentah
        $rawRows = [];
        $rawText = '';
        $loadError = null;

        try {
            if ($dataSource->source_type === 'file' && $dataSource->file_path) {
                $path = public_path('uploads/data_sources/' . $dataSource->file_path);
                if (File::exists($path)) {
                    $rawText = File::get($path);
                    $rawRows = $this->syncService->parseCsvContent($rawText);
                } else {
                    $loadError = "File lokal '{$dataSource->file_path}' tidak ditemukan di server.";
                }
            } elseif ($dataSource->source_type === 'url' && $dataSource->url) {
                $response = Http::withoutVerifying()->timeout(15)->get($dataSource->url);
                if ($response->successful()) {
                    $rawText = $response->body();
                    $rawRows = $this->syncService->parseCsvContent($rawText);
                } else {
                    $loadError = "Gagal mengambil data dari Google Sheet (HTTP {$response->status()}).";
                }
            } elseif ($dataSource->url) {
                // Fallback jika source_type none tapi ada url
                $response = Http::withoutVerifying()->timeout(12)->get($dataSource->url);
                if ($response->successful()) {
                    $rawText = $response->body();
                    $rawRows = $this->syncService->parseCsvContent($rawText);
                }
            }
        } catch (\Throwable $e) {
            $loadError = "Gagal membaca data: " . $e->getMessage();
        }

        // Jika data masih kosong sama sekali, berikan template default 3 kolom 2 baris
        if (empty($rawRows)) {
            $headers = ['Kolom_1', 'Kolom_2', 'Kolom_3'];
            $dataRows = [
                ['Data Contoh 1', 'Nilai A', 'Keterangan A'],
                ['Data Contoh 2', 'Nilai B', 'Keterangan B'],
            ];
        } else {
            // Baris pertama adalah Header
            $headers = $rawRows[0];
            // Normalisasi nama kolom kosong
            foreach ($headers as $idx => $h) {
                if (trim($h) === '') {
                    $headers[$idx] = 'Kolom_' . ($idx + 1);
                }
            }
            $dataRows = array_slice($rawRows, 1);
        }

        return view('admin.page_data.edit', compact(
            'dataSource',
            'pagesUsingThis',
            'fileInfo',
            'headers',
            'dataRows',
            'rawRows',
            'rawText',
            'loadError'
        ));
    }

    /**
     * Simpan hasil modifikasi spreadsheet dari Web ke file CSV server (Web -> CSV)
     */
    public function save(Request $request, string $key)
    {
        $dataSource = DataSource::where('key', $key)->firstOrFail();

        $destDir = public_path('uploads/data_sources');
        if (!File::isDirectory($destDir)) {
            File::makeDirectory($destDir, 0755, true, true);
        }

        $csvString = '';

        // Mode 0: Kirim data berupa raw_rows lengkap (termasuk baris header metadata asli)
        if ($request->has('raw_rows')) {
            $rows = $request->input('raw_rows');
            if (!is_array($rows)) {
                $rows = json_decode($rows, true);
            }

            if (!is_array($rows) || empty($rows)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data baris tidak boleh kosong.'
                ], 422);
            }

            $fp = fopen('php://temp', 'r+');
            foreach ($rows as $row) {
                if (is_array($row)) {
                    fputcsv($fp, $row);
                }
            }
            rewind($fp);
            $csvString = stream_get_contents($fp);
            fclose($fp);
        }
        // Mode 1: Kirim data berupa baris matriks 2D (JSON dari grid visual spreadsheet)
        elseif ($request->has('rows')) {
            $rows = $request->input('rows');
            if (!is_array($rows)) {
                $rows = json_decode($rows, true);
            }

            if (!is_array($rows) || empty($rows)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data baris tidak boleh kosong.'
                ], 422);
            }

            $fp = fopen('php://temp', 'r+');
            foreach ($rows as $row) {
                if (is_array($row)) {
                    fputcsv($fp, $row);
                }
            }
            rewind($fp);
            $csvString = stream_get_contents($fp);
            fclose($fp);
        }
        // Mode 2: Kirim teks CSV mentah
        elseif ($request->has('csv_content')) {
            $csvString = (string) $request->input('csv_content');
            if (trim($csvString) === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Konten teks CSV tidak boleh kosong.'
                ], 422);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan tidak memiliki data CSV yang valid.'
            ], 422);
        }

        // Tulis file CSV lokal baru dengan penamaan konsisten
        $filename = Str::slug($dataSource->key) . '_synced_' . time() . '.csv';
        $fullPath = $destDir . DIRECTORY_SEPARATOR . $filename;
        File::put($fullPath, $csvString);

        // Hapus file lama jika merupakan file sinkronisasi lama untuk key yang sama
        if ($dataSource->file_path && $dataSource->file_path !== $filename) {
            $oldPath = $destDir . DIRECTORY_SEPARATOR . $dataSource->file_path;
            if (File::exists($oldPath) && Str::startsWith($dataSource->file_path, Str::slug($dataSource->key) . '_synced_')) {
                File::delete($oldPath);
            }
        }

        // Update DataSource agar website langsung membaca file CSV hasil modifikasi
        $dataSource->file_path = $filename;
        $dataSource->source_type = 'file';
        $dataSource->is_active = true;
        $dataSource->save();

        // Sinkronkan ulang kartu statistik terkait jika ada
        try {
            $this->syncService->syncAll();
        } catch (\Throwable $e) {
            // Abaikan jika sync kartu ada catatan
        }

        // Mirroring jika asset_csv
        if ($dataSource->key === 'asset_csv') {
            try {
                $rootAssetFile = public_path('Kinerja Bagian Asdiglata UPT Manado 2026 - asset.csv');
                File::put($rootAssetFile, $csvString);

                $parentAssetFile = base_path('../UPT-Manado/Kinerja Bagian Asdiglata UPT Manado 2026 - asset.csv');
                if (File::exists(dirname($parentAssetFile))) {
                    File::put($parentAssetFile, $csvString);
                }
            } catch (\Throwable $e) {}
        }

        // Hapus cache proxy CSV
        \Illuminate\Support\Facades\Cache::flush();

        $rowCount = count($this->syncService->parseCsvContent($csvString));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Perubahan berhasil disimpan ke CSV server ({$rowCount} baris)! Seluruh halaman terkait kini menampilkan data modifikasi terbaru.",
                'file_path' => $filename,
                'rows_count' => $rowCount,
                'updated_at' => now()->format('d M Y H:i:s'),
                'file_size' => number_format(strlen($csvString) / 1024, 1) . ' KB',
            ]);
        }

        return redirect()->route('admin.page-data.edit', $key)
            ->with('success', "✅ Perubahan berhasil disimpan ke file CSV ({$rowCount} baris) dan diterapkan ke website!");
    }

    /**
     * Tarik ulang data segar dari Google Spreadsheet (Google Sheet -> Web/CSV)
     */
    public function pullFromSheet(string $key)
    {
        $dataSource = DataSource::where('key', $key)->firstOrFail();

        if (empty($dataSource->url)) {
            return back()->with('error', "Sumber data '{$dataSource->name}' belum memiliki URL Google Spreadsheet.");
        }

        try {
            $response = Http::withoutVerifying()->timeout(20)->get($dataSource->url);
            if (!$response->successful()) {
                return back()->with('error', "Gagal menghubungi Google Spreadsheet: HTTP {$response->status()}");
            }

            $content = $response->body();
            if (trim($content) === '') {
                return back()->with('error', "Google Spreadsheet mengembalikan data kosong.");
            }

            $destDir = public_path('uploads/data_sources');
            if (!File::isDirectory($destDir)) {
                File::makeDirectory($destDir, 0755, true, true);
            }

            $filename = Str::slug($dataSource->key) . '_synced_' . time() . '.csv';
            $fullPath = $destDir . DIRECTORY_SEPARATOR . $filename;
            File::put($fullPath, $content);

            // Hapus file lama jika synced
            if ($dataSource->file_path && $dataSource->file_path !== $filename) {
                $oldPath = $destDir . DIRECTORY_SEPARATOR . $dataSource->file_path;
                if (File::exists($oldPath) && Str::startsWith($dataSource->file_path, Str::slug($dataSource->key) . '_synced_')) {
                    File::delete($oldPath);
                }
            }

            $dataSource->file_path = $filename;
            $dataSource->source_type = 'file';
            $dataSource->is_active = true;
            $dataSource->save();

            // Re-sync StatCard
            $this->syncService->syncAll();

            // Mirroring jika asset_csv
            if ($dataSource->key === 'asset_csv') {
                try {
                    $rootAssetFile = public_path('Kinerja Bagian Asdiglata UPT Manado 2026 - asset.csv');
                    File::put($rootAssetFile, $content);

                    $parentAssetFile = base_path('../UPT-Manado/Kinerja Bagian Asdiglata UPT Manado 2026 - asset.csv');
                    if (File::exists(dirname($parentAssetFile))) {
                        File::put($parentAssetFile, $content);
                    }
                } catch (\Throwable $e) {}
            }

            \Illuminate\Support\Facades\Cache::flush();

            $rows = $this->syncService->parseCsvContent($content);
            $rowCount = count($rows);

            return back()->with('success', "✅ Berhasil menarik data segar dari Google Spreadsheet! Total {$rowCount} baris data berhasil disinkronkan ke server web.");
        } catch (\Throwable $e) {
            return back()->with('error', "Terjadi kesalahan saat menarik data: " . $e->getMessage());
        }
    }

    /**
     * Alihkan sumber data kembali ke Live Google Sheet URL
     */
    public function resetToLiveSheet(string $key)
    {
        $dataSource = DataSource::where('key', $key)->firstOrFail();

        if (empty($dataSource->url)) {
            return back()->with('error', "Sumber data ini tidak memiliki link Google Spreadsheet.");
        }

        $dataSource->source_type = 'url';
        $dataSource->save();

        // Re-sync StatCard
        try {
            $this->syncService->syncAll();
        } catch (\Throwable $e) {}

        return back()->with('success', "✅ Mode sumber data '{$dataSource->name}' dialihkan kembali ke Google Spreadsheet Live URL.");
    }

    /**
     * Download file CSV terkini dari server untuk diekspor kembali ke Google Sheet / Excel
     */
    public function download(string $key)
    {
        $dataSource = DataSource::where('key', $key)->firstOrFail();

        $content = '';
        if ($dataSource->source_type === 'file' && $dataSource->file_path) {
            $path = public_path('uploads/data_sources/' . $dataSource->file_path);
            if (File::exists($path)) {
                $content = File::get($path);
            }
        }

        if (empty($content) && $dataSource->url) {
            try {
                $res = Http::withoutVerifying()->timeout(15)->get($dataSource->url);
                if ($res->successful()) {
                    $content = $res->body();
                }
            } catch (\Throwable $e) {}
        }

        if (empty($content)) {
            return back()->with('error', "Tidak ada data CSV yang tersedia untuk diunduh.");
        }

        $downloadFilename = $dataSource->key . '_' . date('Ymd_His') . '.csv';

        return response($content, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$downloadFilename}\"",
        ]);
    }

    /**
     * Unggah file CSV baru untuk menimpa data sumber data halaman ini
     */
    public function upload(Request $request, string $key)
    {
        $dataSource = DataSource::where('key', $key)->firstOrFail();

        $request->validate([
            'csv_file' => 'required|file|max:20480',
        ], [
            'csv_file.required' => 'Pilih file CSV yang ingin diunggah.',
            'csv_file.max' => 'Ukuran file CSV maksimal 20 MB.',
        ]);

        $file = $request->file('csv_file');
        $ext = $file->getClientOriginalExtension() ?: 'csv';
        $filename = Str::slug($dataSource->key) . '_synced_' . time() . '.' . $ext;
        $destDir = public_path('uploads/data_sources');

        if (!File::isDirectory($destDir)) {
            File::makeDirectory($destDir, 0755, true, true);
        }

        // Hapus file lama jika synced
        if ($dataSource->file_path) {
            $oldPath = $destDir . DIRECTORY_SEPARATOR . $dataSource->file_path;
            if (File::exists($oldPath) && Str::startsWith($dataSource->file_path, Str::slug($dataSource->key) . '_synced_')) {
                File::delete($oldPath);
            }
        }

        $file->move($destDir, $filename);

        $dataSource->file_path = $filename;
        $dataSource->source_type = 'file';
        $dataSource->is_active = true;
        $dataSource->save();

        try {
            $this->syncService->syncAll();
        } catch (\Throwable $e) {}

        if ($dataSource->key === 'asset_csv') {
            try {
                $copiedContent = File::get($destDir . DIRECTORY_SEPARATOR . $filename);
                $rootAssetFile = public_path('Kinerja Bagian Asdiglata UPT Manado 2026 - asset.csv');
                File::put($rootAssetFile, $copiedContent);

                $parentAssetFile = base_path('../UPT-Manado/Kinerja Bagian Asdiglata UPT Manado 2026 - asset.csv');
                if (File::exists(dirname($parentAssetFile))) {
                    File::put($parentAssetFile, $copiedContent);
                }
            } catch (\Throwable $e) {}
        }

        \Illuminate\Support\Facades\Cache::flush();

        return back()->with('success', "✅ File CSV baru berhasil diunggah dan langsung aktif di halaman website!");
    }

    /**
     * Helper untuk mengambil metadata file lokal DataSource
     */
    protected function getSourceFileInfo(DataSource $dataSource): array
    {
        $info = [
            'has_file' => false,
            'filename' => $dataSource->file_path,
            'file_size' => '-',
            'updated_at' => $dataSource->updated_at ? $dataSource->updated_at->format('d M Y H:i') : '-',
            'rows_count' => null,
            'is_synced_file' => false,
        ];

        if ($dataSource->file_path) {
            $path = public_path('uploads/data_sources/' . $dataSource->file_path);
            if (File::exists($path)) {
                $info['has_file'] = true;
                $bytes = File::size($path);
                $info['file_size'] = number_format($bytes / 1024, 1) . ' KB';
                $info['updated_at'] = date('d M Y H:i', File::lastModified($path));
                $info['is_synced_file'] = Str::contains($dataSource->file_path, '_synced_');
            }
        }

        return $info;
    }
}
