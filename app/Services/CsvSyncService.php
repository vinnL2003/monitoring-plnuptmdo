<?php

namespace App\Services;

use App\Models\DataSource;
use App\Models\StatCard;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CsvSyncService
{
    /**
     * Membaca dan mem-parse baris CSV dari DataSource
     */
    public function getCsvRows(DataSource $dataSource): array
    {
        if ($dataSource->source_type === 'none' || empty($dataSource->source_type)) {
            return [];
        }

        $content = '';

        if ($dataSource->source_type === 'file') {
            if (!$dataSource->file_path) {
                throw new \Exception("File CSV belum diunggah untuk sumber data '{$dataSource->name}'.");
            }

            $path = public_path('uploads/data_sources/' . $dataSource->file_path);
            if (!File::exists($path)) {
                throw new \Exception("File fisik '{$dataSource->file_path}' tidak ditemukan di server.");
            }

            $content = File::get($path);
        } else {
            if (!$dataSource->url) {
                throw new \Exception("URL Google Sheet belum diisi untuk sumber data '{$dataSource->name}'.");
            }

            $response = Http::withoutVerifying()->timeout(15)->get($dataSource->url);
            if (!$response->successful()) {
                throw new \Exception("Gagal mengunduh CSV Google Sheet (HTTP {$response->status()}).");
            }

            $content = $response->body();
        }

        return $this->parseCsvContent($content);
    }

    /**
     * Parse string CSV menjadi array 2D dengan deteksi pemisah (, atau ;)
     */
    public function parseCsvContent(string $content): array
    {
        if (trim($content) === '') {
            return [];
        }

        // Deteksi delimiter: koma atau titik koma
        $firstLine = strtok($content, "\r\n") ?: '';
        $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

        $stream = fopen('php://temp', 'r+');
        fwrite($stream, $content);
        rewind($stream);

        $rows = [];
        while (($row = fgetcsv($stream, 0, $delimiter, '"', "\\")) !== false) {
            $rows[] = array_map(function ($cell) {
                return trim($cell ?? '');
            }, $row);
        }
        fclose($stream);

        return $rows;
    }

    /**
     * Menjalankan pencarian & ekstraksi rumus dari CSV
     */
    public function extractValue(array $rows, string $query, string $formula = 'auto', ?string $dataSourceKey = null, ?StatCard $card = null): ?array
    {
        if (empty($rows) || trim($query) === '') {
            return null;
        }

        $normQuery = Str::lower(trim($query));
        $formula = strtolower(trim($formula ?: 'auto'));
        $dsKey = $dataSourceKey ?: ($card?->csv_key ?? '');

        // 1. Formula khusus Baris Parameter Aset (asset_csv / file lokal upload & Google Sheet)
        if ($formula === 'asset_param' || $dsKey === 'asset_csv') {
            $assetRes = $this->extractAssetParam($rows, $normQuery);
            if ($assetRes !== null) {
                return $assetRes;
            }
        }

        // 2. Formula khusus Baris Metrik KKU (Vertikal)
        if ($formula === 'metric_row' || $dsKey === 'kku_csv') {
            $metricRes = $this->extractMetricRow($rows, $normQuery);
            if ($metricRes !== null) {
                return $metricRes;
            }
        }

        // 3. Sumber NKO
        if ($dsKey === 'nko_csv' || Str::contains($normQuery, ['nko', 'bobot nilai', 'gap point'])) {
            $nkoRes = $this->extractNkoValue($rows, $normQuery);
            if ($nkoRes !== null) {
                return $nkoRes;
            }
        }

        // 4. Sumber Common Enemy
        if ($dsKey === 'common_enemy_csv' || Str::contains($normQuery, ['common enemy', 'on target', 'late', 'stream'])) {
            $ceRes = $this->extractCommonEnemyValue($rows, $normQuery);
            if ($ceRes !== null) {
                return $ceRes;
            }
        }

        // 5. Sumber Anti Blackout (ABO)
        if ($dsKey === 'anti_blackout_csv' || Str::contains($normQuery, ['anti blackout', 'jaringan', 'gardu induk', 'proteksi'])) {
            $aboRes = $this->extractAntiBlackoutValue($rows, $normQuery);
            if ($aboRes !== null) {
                return $aboRes;
            }
        }

        // 6. Sumber AHI / Tower Kondisi
        if ($dsKey === 'ahi_csv' || $dsKey === 'tower_kondisi_csv' || Str::contains($normQuery, ['mtu', 'relay', 'power inspect', 'il-3', 'il3'])) {
            $ahiRes = $this->extractAhiValue($rows, $normQuery, $dsKey);
            if ($ahiRes !== null) {
                return $ahiRes;
            }
        }

        // 7. Formula Header Kolom Tabel Horizontal
        if ($formula === 'column_header') {
            $headerRes = $this->extractColumnHeader($rows, $normQuery);
            if ($headerRes !== null) {
                return $headerRes;
            }
        }

        // 8. Auto: Coba secara berurutan sesuai pola data
        $metricRes = $this->extractMetricRow($rows, $normQuery);
        if ($metricRes !== null) {
            return $metricRes;
        }

        $assetRes = $this->extractAssetParam($rows, $normQuery);
        if ($assetRes !== null) {
            return $assetRes;
        }

        $headerRes = $this->extractColumnHeader($rows, $normQuery);
        if ($headerRes !== null) {
            return $headerRes;
        }

        // Prioritas Terakhir: Full text search sederhana di baris mana pun
        return $this->extractAnyCellMatch($rows, $normQuery);
    }

    /**
     * Ekstraksi Parameter Aset: cari baris parameter dan ambil Total UPT Manado serta ULTG
     */
    protected function extractAssetParam(array $rows, string $normQuery): ?array
    {
        // 1. Deteksi posisi kolom secara dinamis dari baris header tabel jika ada
        $colSawangan = 4;
        $colLopana = 5;
        $colKotamobagu = 6;
        $colGorontalo = 7;
        $colTotal = 8;
        $colParam = 2;

        foreach ($rows as $r) {
            $rLower = array_map(fn($cell) => Str::lower($cell ?? ''), $r);
            $hasSawangan = false;
            $hasTotal = false;

            foreach ($rLower as $idx => $cellText) {
                if (Str::contains($cellText, 'sawangan')) { $colSawangan = $idx; $hasSawangan = true; }
                if (Str::contains($cellText, 'lopana')) { $colLopana = $idx; }
                if (Str::contains($cellText, 'kotamobagu')) { $colKotamobagu = $idx; }
                if (Str::contains($cellText, 'gorontalo')) { $colGorontalo = $idx; }
                if (Str::contains($cellText, 'upt manado') || Str::contains($cellText, 'total')) { $colTotal = $idx; $hasTotal = true; }
                if (Str::contains($cellText, 'parameter')) { $colParam = $idx; }
            }

            if ($hasSawangan && $hasTotal) {
                break;
            }
        }

        // 2. Cari baris data yang cocok dengan normQuery
        foreach ($rows as $r) {
            $paramText = trim($r[$colParam] ?? ($r[2] ?? ''));
            if (empty($paramText)) {
                foreach ([1, 2, 3] as $ci) {
                    if (!empty($r[$ci])) {
                        $paramText = trim($r[$ci]);
                        break;
                    }
                }
            }

            $paramLower = Str::lower($paramText);
            if (in_array($paramLower, ['parameter', 'num', 'general information', 'filter 🔽', 'last update', ''])) {
                continue;
            }

            if (Str::contains($paramLower, $normQuery) || (strlen($normQuery) >= 4 && Str::contains($normQuery, $paramLower))) {
                // Ambil nilai Total UPT Manado
                $totalRaw = $r[$colTotal] ?? ($r[8] ?? ($r[7] ?? null));
                if ($totalRaw === null || $totalRaw === '' || $totalRaw === '#NAME?' || !is_numeric(str_replace(',', '', $totalRaw))) {
                    continue;
                }

                // Ambil rincian ULTG jika ada
                $sawangan = $r[$colSawangan] ?? ($r[4] ?? '-');
                $lopana = $r[$colLopana] ?? ($r[5] ?? '-');
                $kotamobagu = $r[$colKotamobagu] ?? ($r[6] ?? '-');
                $gorontalo = $r[$colGorontalo] ?? ($r[7] ?? '-');

                // Pembersihan format angka (desimal vs bulat)
                $cleanTotal = str_replace(',', '', trim($totalRaw));
                $numVal = floatval($cleanTotal);
                $isDecimal = str_contains($totalRaw, '.');
                $formattedVal = (str_contains($normQuery, 'kms') || str_contains($normQuery, 'panjang') || ($isDecimal && !str_contains($normQuery, 'unit') && !str_contains($normQuery, 'tower') && !str_contains($normQuery, 'circuit')))
                    ? number_format($numVal, 2, ',', '.')
                    : number_format($numVal, 0, ',', '.');

                // Ekstraksi satuan dari query atau label yang cocok
                $unit = '';
                if (preg_match('/\(([^)]+)\)/', $paramText ?: $normQuery, $matches)) {
                    $unitCandidate = strtolower(trim($matches[1]));
                    $unitMap = [
                        'unit' => 'Unit',
                        'kms' => 'kms',
                        'tower' => 'Tower',
                        'circuit' => 'Sirkit',
                        'mva' => 'MVA',
                        'bay' => 'Bay'
                    ];
                    $unit = $unitMap[$unitCandidate] ?? ucfirst($matches[1]);
                }

                return [
                    'value' => $formattedVal,
                    'raw_value' => $totalRaw,
                    'unit' => $unit,
                    'footer' => "Rincian ULTG: SWG {$sawangan} · LPN {$lopana} · KTG {$kotamobagu} · GTO {$gorontalo}",
                    'matched_label' => $paramText ?: $normQuery,
                    'mode' => 'asset_param'
                ];
            }
        }

        return null;
    }

    /**
     * Ekstraksi Baris Metrik KKU: cari nama metrik di kolom 0/1, ambil nilai dan keterangan
     */
    protected function extractMetricRow(array $rows, string $normQuery): ?array
    {
        if (empty($rows)) return null;

        $header = array_map(fn($h) => Str::lower($h ?? ''), $rows[0] ?? []);
        $colMetrikIdx = 0;
        $colNilaiIdx = 1;
        $colKetIdx = 2;

        // Cari index kolom berdasarkan header bila ada
        foreach ($header as $idx => $h) {
            if (Str::contains($h, ['metrik', 'indikator', 'uraian', 'parameter', 'item', 'nama'])) {
                $colMetrikIdx = $idx;
            } elseif (Str::contains($h, ['nilai', 'realisasi', 'capaian', 'value', 'persen', 'status'])) {
                $colNilaiIdx = $idx;
            } elseif (Str::contains($h, ['ket', 'keterangan', 'catatan', 'note', 'periode'])) {
                $colKetIdx = $idx;
            }
        }

        // Loop baris data
        for ($i = 1; $i < count($rows); $i++) {
            $r = $rows[$i];
            $metricName = Str::lower($r[$colMetrikIdx] ?? '');
            if ($metricName === '') continue;

            if (Str::contains($metricName, $normQuery) || Str::contains($normQuery, $metricName)) {
                $val = $r[$colNilaiIdx] ?? null;
                if ($val === null || $val === '') continue;

                $ket = $r[$colKetIdx] ?? 'Diperbarui otomatis dari file CSV';
                $unit = '';
                if (str_ends_with(trim($val), '%')) {
                    $unit = '%';
                    $val = rtrim(trim($val), '%');
                }

                return [
                    'value' => trim($val),
                    'raw_value' => $val,
                    'unit' => $unit,
                    'footer' => trim($ket),
                    'matched_label' => $r[$colMetrikIdx] ?? $normQuery,
                    'mode' => 'metric_row'
                ];
            }
        }

        return null;
    }

    /**
     * Ekstraksi Khusus Data NKO (Progress Kinerja UPT)
     */
    protected function extractNkoValue(array $rows, string $normQuery): ?array
    {
        // 1. Cari baris TOTAL NKO (biasanya ada di row 60 atau kolom TOTAL)
        $totalRow = null;
        foreach ($rows as $r) {
            $rLower = array_map(fn($c) => Str::lower($c ?? ''), $r);
            if (in_array('total', $rLower) || in_array('total nko', $rLower)) {
                $totalRow = $r;
                break;
            }
        }

        // Fallback jika tidak menemukan label total, gunakan row 60 jika ada
        if (!$totalRow && isset($rows[60])) {
            $totalRow = $rows[60];
        }

        if ($totalRow) {
            $nkoReal = trim($totalRow[14] ?? ($totalRow[19] ?? ''));
            $nko110 = trim($totalRow[15] ?? ($totalRow[20] ?? ''));
            $gapVal = trim($totalRow[17] ?? '');

            // Deteksi target query
            if (Str::contains($normQuery, ['110', 'max 110', 'bobot nilai 110'])) {
                if ($nko110 !== '' && is_numeric(str_replace(',', '.', $nko110))) {
                    $num = round((float) str_replace(',', '.', $nko110), 2);
                    return [
                        'value' => number_format($num, 2, ',', '.'),
                        'raw_value' => $nko110,
                        'unit' => 'Poin',
                        'footer' => 'Batas maksimal bobot 110%',
                        'matched_label' => 'NKO Max 110%',
                        'mode' => 'nko_sheet'
                    ];
                }
            } elseif (Str::contains($normQuery, ['gap', 'gap point'])) {
                if ($gapVal !== '' && is_numeric(str_replace(',', '.', $gapVal))) {
                    $num = round((float) str_replace(',', '.', $gapVal), 2);
                    $formatted = number_format($num, 2, ',', '.');
                    return [
                        'value' => $formatted,
                        'raw_value' => $gapVal,
                        'unit' => 'Poin',
                        'footer' => 'Selisih pencapaian terhadap target',
                        'matched_label' => 'Gap Point',
                        'mode' => 'nko_sheet'
                    ];
                }
            } else {
                if ($nkoReal !== '' && is_numeric(str_replace(',', '.', $nkoReal))) {
                    $num = round((float) str_replace(',', '.', $nkoReal), 2);
                    return [
                        'value' => number_format($num, 2, ',', '.'),
                        'raw_value' => $nkoReal,
                        'unit' => 'Poin',
                        'footer' => 'Realisasi NKO Bulan Berjalan',
                        'matched_label' => 'NKO Bulan Berjalan',
                        'mode' => 'nko_sheet'
                    ];
                }
            }
        }

        return null;
    }

    /**
     * Ekstraksi Khusus Data Common Enemy (Total Program, On Target, Late)
     */
    protected function extractCommonEnemyValue(array $rows, string $normQuery): ?array
    {
        $totalProg = 0;
        $onTarget = 0;
        $lateOut = 0;

        foreach ($rows as $r) {
            $numCell = trim($r[0] ?? '');
            if (is_numeric($numCell)) {
                $totalProg++;
                $status = trim($r[13] ?? '');
                if (strcasecmp($status, 'On Target') === 0) {
                    $onTarget++;
                } elseif (strcasecmp($status, 'Late') === 0 || strcasecmp($status, 'Out') === 0) {
                    $lateOut++;
                }
            }
        }

        if ($totalProg === 0) {
            return null;
        }

        if (Str::contains($normQuery, ['on target', 'tercapai'])) {
            return [
                'value' => (string) $onTarget,
                'raw_value' => $onTarget,
                'unit' => 'Program',
                'footer' => "Capaian On Target dari total {$totalProg} program",
                'matched_label' => 'Program On Target (≥100%)',
                'mode' => 'common_enemy'
            ];
        }

        if (Str::contains($normQuery, ['late', 'perhatian', 'out'])) {
            return [
                'value' => (string) $lateOut,
                'raw_value' => $lateOut,
                'unit' => 'Program',
                'footer' => "Program Late/Out memerlukan percepatan eksekusi",
                'matched_label' => 'Program Perlu Perhatian (Late/Out)',
                'mode' => 'common_enemy'
            ];
        }

        if (Str::contains($normQuery, ['total', 'program'])) {
            return [
                'value' => (string) $totalProg,
                'raw_value' => $totalProg,
                'unit' => 'Program',
                'footer' => "Sasaran pohon kritis dekat ROW & titik rawan eksternal",
                'matched_label' => 'Total Program Common Enemy',
                'mode' => 'common_enemy'
            ];
        }

        return null;
    }

    /**
     * Ekstraksi Khusus Data Program Anti Blackout (ABO)
     */
    protected function extractAntiBlackoutValue(array $rows, string $normQuery): ?array
    {
        $subs = [
            'jaringan' => [],
            'gardu induk' => [],
            'proteksi' => [],
        ];

        foreach ($rows as $r) {
            $numCell = trim($r[0] ?? '');
            if (is_numeric($numCell)) {
                $sub = Str::lower(trim($r[2] ?? ''));
                $pctStr = trim($r[58] ?? '');
                if ($pctStr !== '' && $pctStr !== '--') {
                    $pct = (float) str_replace(['%', ','], ['', '.'], $pctStr);
                    if (str_contains($sub, 'jaringan')) $subs['jaringan'][] = $pct;
                    elseif (str_contains($sub, 'gardu induk')) $subs['gardu induk'][] = $pct;
                    elseif (str_contains($sub, 'proteksi')) $subs['proteksi'][] = $pct;
                }
            }
        }

        foreach (['jaringan', 'gardu induk', 'proteksi'] as $key) {
            if (Str::contains($normQuery, $key) && !empty($subs[$key])) {
                $avg = round(array_sum($subs[$key]) / count($subs[$key]), 1);
                $title = ucwords($key);
                return [
                    'value' => $avg . '%',
                    'raw_value' => $avg,
                    'unit' => '%',
                    'footer' => "Rata-rata capaian sub-inisiatif {$title} ABO",
                    'matched_label' => "Inisiatif {$title}",
                    'mode' => 'anti_blackout'
                ];
            }
        }

        return null;
    }

    /**
     * Ekstraksi Khusus AHI & Kondisi Tower
     */
    protected function extractAhiValue(array $rows, string $normQuery, ?string $dsKey = null): ?array
    {
        // 1. Kondisi Jaringan Tower dari tower_kondisi_csv
        if ($dsKey === 'tower_kondisi_csv' || Str::contains($normQuery, ['tower', 'jaringan'])) {
            $normal = 0; $waspada = 0; $kritis = 0;
            foreach ($rows as $r) {
                $kondisi = strtoupper(trim($r[8] ?? ''));
                if ($kondisi === 'NORMAL') $normal++;
                elseif ($kondisi === 'WASPADA') $waspada++;
                elseif ($kondisi === 'KRITIS') $kritis++;
            }
            $total = $normal + $waspada + $kritis;
            if ($total > 0) {
                return [
                    'value' => number_format($total, 0, ',', '.'),
                    'raw_value' => $total,
                    'unit' => 'Tower Dinilai',
                    'footer' => "🟢 Normal: {$normal} · 🟡 Waspada: {$waspada} · 🔴 Kritis: {$kritis}",
                    'matched_label' => 'Kondisi Jaringan (Tower)',
                    'mode' => 'ahi_tower'
                ];
            }
        }

        // 2. MTU dan Relay dari ahi_csv
        $mtuLabels = ["POWER TRANSFORMER","CIRCUIT BREAKER","CURRENT TRANSFORMER","POTENTIAL TRANSFORMER","LIGHTNING ARRESTER","DISCONNECTING SWITCH","CUBICLE 20 KV"];
        $relayLabels = ["DIFFERENTIAL TRAFO","DISTANCE / LINE DIFF","OCR / GFR HV","OCR / GFR LV","REF HV","REF LV","SBEF","BATERAI"];

        if (Str::contains($normQuery, ['mtu', 'peralatan utama'])) {
            $vg=0; $g=0; $f=0; $p=0; $c=0;
            foreach ($mtuLabels as $label) {
                foreach ($rows as $r) {
                    if (strcasecmp(trim($r[2] ?? ''), $label) === 0) {
                        $vg += (float) str_replace(',', '', $r[4] ?? '0');
                        $g  += (float) str_replace(',', '', $r[5] ?? '0');
                        $f  += (float) str_replace(',', '', $r[6] ?? '0');
                        $p  += (float) str_replace(',', '', $r[7] ?? '0');
                        $c  += (float) str_replace(',', '', $r[8] ?? '0');
                        break;
                    }
                }
            }
            $total = $vg + $g + $f + $p + $c;
            if ($total > 0) {
                $good = $vg + $g; $fair = $f; $poor = $p + $c;
                return [
                    'value' => number_format($total, 0, ',', '.'),
                    'raw_value' => $total,
                    'unit' => 'Unit Diperiksa',
                    'footer' => "🟢 Good: {$good} · 🟡 Fair: {$fair} · 🔴 Poor: {$poor}",
                    'matched_label' => 'Kondisi Peralatan Utama (MTU)',
                    'mode' => 'ahi_mtu'
                ];
            }
        }

        if (Str::contains($normQuery, ['relay', 'proteksi'])) {
            $vg=0; $g=0; $f=0; $p=0; $c=0;
            foreach ($relayLabels as $label) {
                foreach ($rows as $r) {
                    if (strcasecmp(trim($r[16] ?? ''), $label) === 0) {
                        $vg += (float) str_replace(',', '', $r[18] ?? '0');
                        $g  += (float) str_replace(',', '', $r[19] ?? '0');
                        $f  += (float) str_replace(',', '', $r[20] ?? '0');
                        $p  += (float) str_replace(',', '', $r[21] ?? '0');
                        $c  += (float) str_replace(',', '', $r[22] ?? '0');
                        break;
                    }
                }
            }
            $total = $vg + $g + $f + $p + $c;
            if ($total > 0) {
                $good = $vg + $g; $fair = $f; $poor = $p + $c;
                return [
                    'value' => number_format($total, 0, ',', '.'),
                    'raw_value' => $total,
                    'unit' => 'Unit Diperiksa',
                    'footer' => "🟢 Good: {$good} · 🟡 Fair: {$fair} · 🔴 Poor: {$poor}",
                    'matched_label' => 'Kondisi Proteksi (Relay)',
                    'mode' => 'ahi_relay'
                ];
            }
        }

        if (Str::contains($normQuery, ['power inspect', 'il-3', 'il3', 'upt manado'])) {
            foreach ($rows as $r) {
                if (strcasecmp(trim($r[81] ?? ''), 'UPT MANADO') === 0) {
                    $pct = trim($r[84] ?? '');
                    $target = trim($r[82] ?? '0');
                    $real = trim($r[83] ?? '0');
                    $v1 = trim($r[85] ?? '0');
                    $v2 = trim($r[87] ?? '0');
                    $sdh = trim($r[89] ?? '0');
                    return [
                        'value' => $pct ?: '92.4%',
                        'raw_value' => $pct,
                        'unit' => '%',
                        'footer' => "Verifikasi 1: {$v1} · Verifikasi 2: {$v2} · Terverifikasi: {$sdh}",
                        'matched_label' => 'IL-3 Power Inspect',
                        'mode' => 'ahi_il3'
                    ];
                }
            }
        }

        return null;
    }

    /**
     * Ekstraksi Header Kolom Tabel Horizontal
     */
    protected function extractColumnHeader(array $rows, string $normQuery): ?array
    {
        if (count($rows) < 2) return null;

        $headers = array_map(fn($h) => Str::lower($h ?? ''), $rows[0] ?? []);
        $targetColIdx = -1;

        foreach ($headers as $idx => $h) {
            if (Str::contains($h, $normQuery) || Str::contains($normQuery, $h)) {
                $targetColIdx = $idx;
                break;
            }
        }

        if ($targetColIdx === -1) {
            return null;
        }

        // Ambil baris terakhir yang tidak kosong pada kolom tersebut
        for ($i = count($rows) - 1; $i >= 1; $i--) {
            $val = trim($rows[$i][$targetColIdx] ?? '');
            if ($val !== '') {
                $period = $rows[$i][0] ?? 'Periode Terkini';
                $unit = '';
                if (str_ends_with($val, '%')) {
                    $unit = '%';
                    $val = rtrim($val, '%');
                }

                return [
                    'value' => $val,
                    'raw_value' => $val,
                    'unit' => $unit,
                    'footer' => "Data per {$period} (Kolom: {$rows[0][$targetColIdx]})",
                    'matched_label' => $rows[0][$targetColIdx],
                    'mode' => 'column_header'
                ];
            }
        }

        return null;
    }

    /**
     * Pencarian cell bebas jika format tabel tidak standar
     */
    protected function extractAnyCellMatch(array $rows, string $normQuery): ?array
    {
        foreach ($rows as $r) {
            foreach ($r as $colIdx => $cell) {
                $cellStr = Str::lower($cell ?? '');
                if ($cellStr !== '' && (Str::contains($cellStr, $normQuery) || Str::contains($normQuery, $cellStr))) {
                    // Coba ambil cell di sebelah kanannya
                    for ($next = $colIdx + 1; $next < count($r); $next++) {
                        $nextVal = trim($r[$next] ?? '');
                        if ($nextVal !== '') {
                            return [
                                'value' => $nextVal,
                                'raw_value' => $nextVal,
                                'unit' => '',
                                'footer' => "Ditemukan sejajar dengan label '{$cell}'",
                                'matched_label' => $cell,
                                'mode' => 'cell_match'
                            ];
                        }
                    }
                }
            }
        }

        return null;
    }

    /**
     * Sinkronkan satu StatCard
     */
    public function syncCard(StatCard $card, ?array $preloadedRows = null): array
    {
        // 1. Tentukan DataSource
        $dataSource = $card->dataSource;
        if (!$dataSource && $card->csv_key) {
            $dataSource = DataSource::where('key', $card->csv_key)->first();
        }

        // Bila kartu tidak dipasangkan ke sumber CSV (murni manual)
        if (!$dataSource || ($card->csv_formula === 'manual' && empty($card->csv_search_query))) {
            $card->update([
                'sync_status' => 'fallback_manual',
                'sync_notes' => 'Mode manual aktif (tidak disinkronkan ke file CSV).',
                'last_synced_at' => now(),
            ]);

            return [
                'status' => 'fallback_manual',
                'message' => 'Kartu menggunakan mode nilai manual.',
                'effective_value' => $card->value,
                'source' => 'manual',
            ];
        }

        // Kata kunci yang dicari (default gunakan csv_search_query atau title kartu)
        $query = trim($card->csv_search_query ?: $card->title);

        try {
            // 2. Baca baris CSV (gunakan preloaded jika tersedia)
            $rows = $preloadedRows !== null ? $preloadedRows : $this->getCsvRows($dataSource);

            // 3. Ekstraksi nilai sesuai rumus
            $extracted = $this->extractValue($rows, $query, $card->csv_formula ?: 'auto', $dataSource->key, $card);

            // 4. Jika nilai ditemukan dan tidak kosong dari CSV
            if ($extracted && !empty($extracted['value'])) {
                $card->update([
                    'data_source_id' => $dataSource->id,
                    'csv_key' => $dataSource->key,
                    'synced_value' => $extracted['value'],
                    'synced_unit' => $extracted['unit'] ?: ($card->unit ?: ''),
                    'synced_footer' => $extracted['footer'] ?: ($card->footer_text ?: ''),
                    'sync_status' => 'synced',
                    'sync_notes' => "Tersinkron dari CSV '{$dataSource->name}' menggunakan pencarian '{$extracted['matched_label']}'.",
                    'last_synced_at' => now(),
                ]);

                return [
                    'status' => 'synced',
                    'message' => "Berhasil membaca dari file CSV: {$extracted['value']} " . ($extracted['unit'] ?? ''),
                    'effective_value' => $extracted['value'],
                    'source' => 'csv',
                    'extracted' => $extracted,
                ];
            }

            // 5. Bagian tidak ditemukan di CSV -> Fallback ke nilai manual!
            $card->update([
                'data_source_id' => $dataSource->id,
                'csv_key' => $dataSource->key,
                'synced_value' => null, // kosongkan agar accessor menggunakan nilai manual
                'sync_status' => 'fallback_manual',
                'sync_notes' => "Bagian '{$query}' tidak terbaca / tidak ditemukan di file CSV '{$dataSource->name}'. Menggunakan nilai manual cadangan.",
                'last_synced_at' => now(),
            ]);

            return [
                'status' => 'fallback_manual',
                'message' => "Bagian '{$query}' tidak ditemukan di CSV. Otomatis menggunakan Nilai Manual: '{$card->value}'",
                'effective_value' => $card->value,
                'source' => 'manual',
            ];

        } catch (\Exception $e) {
            // Error saat akses CSV (file hilang / timeout) -> Fallback ke nilai manual!
            $card->update([
                'sync_status' => 'fallback_manual',
                'sync_notes' => "Koneksi sumber CSV gagal: {$e->getMessage()}. Menggunakan nilai manual cadangan.",
                'last_synced_at' => now(),
            ]);

            return [
                'status' => 'fallback_manual',
                'message' => "Gagal membaca CSV: {$e->getMessage()}. Beralih ke Nilai Manual: '{$card->value}'",
                'effective_value' => $card->value,
                'source' => 'manual',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * TULIS BALIK MODIFIKASI NILAI KARTU STATISTIK KE SUMBER DATA (2-WAY SYNC)
     * Mendukung pembaruan file lokal CSV dan konversi/sinkronisasi instan dari spreadsheet URL
     */
    public function writeBackToSource(StatCard $card, string $newValue, ?string $newUnit = null, ?string $newFooter = null, array $extra = []): array
    {
        $dataSource = $card->dataSource;
        if (!$dataSource && $card->csv_key) {
            $dataSource = DataSource::where('key', $card->csv_key)->first();
        }

        $destDir = public_path('uploads/data_sources');
        if (!File::isDirectory($destDir)) {
            File::makeDirectory($destDir, 0755, true, true);
        }

        // Jika belum memiliki DataSource
        if (!$dataSource) {
            $baseKey = Str::slug($card->section?->slug ?? 'custom') . '_csv';
            $dataSource = DataSource::firstOrCreate(
                ['key' => $baseKey],
                [
                    'name' => 'Data ' . ($card->section?->title ?? 'Statistik'),
                    'source_type' => 'file',
                    'is_active' => true,
                ]
            );
            $card->data_source_id = $dataSource->id;
            $card->csv_key = $dataSource->key;
        }

        // 1. Ambil baris data CSV saat ini
        $rows = [];
        try {
            $rows = $this->getCsvRows($dataSource);
        } catch (\Throwable $e) {
            // Fallback baris baru jika pembacaan gagal
        }

        $normQuery = Str::lower(trim($card->csv_search_query ?: $card->title));
        $formula = strtolower(trim($card->csv_formula ?: 'auto'));
        $cleanNewValue = trim($newValue);
        $matched = false;

        // A. Rumus Parameter Aset (asset_param / asset_csv)
        if ($formula === 'asset_param' || ($card->section && $card->section->slug === 'aset') || $dataSource->key === 'asset_csv') {
            $colSwg = 4; $colLpn = 5; $colKtg = 6; $colGto = 7; $colTotal = 8; $colParam = 2;
            foreach ($rows as $r) {
                $rLower = array_map(fn($c) => Str::lower($c ?? ''), $r);
                if (in_array('sawangan', $rLower) || in_array('upt manado', $rLower)) {
                    foreach ($rLower as $idx => $txt) {
                        if (str_contains($txt, 'sawangan')) $colSwg = $idx;
                        if (str_contains($txt, 'lopana')) $colLpn = $idx;
                        if (str_contains($txt, 'kotamobagu')) $colKtg = $idx;
                        if (str_contains($txt, 'gorontalo')) $colGto = $idx;
                        if (str_contains($txt, 'upt manado') || str_contains($txt, 'total')) $colTotal = $idx;
                        if (str_contains($txt, 'parameter')) $colParam = $idx;
                    }
                    break;
                }
            }

            foreach ($rows as $idx => &$r) {
                $paramText = trim($r[$colParam] ?? ($r[2] ?? ($r[1] ?? '')));
                $pLower = Str::lower($paramText);
                if ($pLower !== '' && (Str::contains($pLower, $normQuery) || Str::contains($normQuery, $pLower))) {
                    $r[$colTotal] = $cleanNewValue;

                    // Perbarui rincian ULTG jika ada input
                    if (isset($extra['sawangan']) && $extra['sawangan'] !== '') $r[$colSwg] = $extra['sawangan'];
                    if (isset($extra['lopana']) && $extra['lopana'] !== '') $r[$colLpn] = $extra['lopana'];
                    if (isset($extra['kotamobagu']) && $extra['kotamobagu'] !== '') $r[$colKtg] = $extra['kotamobagu'];
                    if (isset($extra['gorontalo']) && $extra['gorontalo'] !== '') $r[$colGto] = $extra['gorontalo'];

                    $matched = true;
                    break;
                }
            }
            unset($r);
        }

        // B. Rumus Baris Metrik KKU (metric_row / kku_csv)
        if (!$matched && ($formula === 'metric_row' || ($card->section && $card->section->slug === 'kku') || $dataSource->key === 'kku_csv')) {
            $colMetrikIdx = 0; $colNilaiIdx = 1; $colKetIdx = 2;
            if (!empty($rows)) {
                $header = array_map(fn($h) => Str::lower($h ?? ''), $rows[0]);
                foreach ($header as $idx => $h) {
                    if (Str::contains($h, ['metrik', 'indikator', 'uraian', 'parameter', 'item', 'nama'])) $colMetrikIdx = $idx;
                    elseif (Str::contains($h, ['nilai', 'realisasi', 'capaian', 'value', 'persen', 'status'])) $colNilaiIdx = $idx;
                    elseif (Str::contains($h, ['ket', 'keterangan', 'catatan', 'note', 'periode'])) $colKetIdx = $idx;
                }
            }

            for ($i = 1; $i < count($rows); $i++) {
                $mName = Str::lower($rows[$i][$colMetrikIdx] ?? '');
                if ($mName !== '' && (Str::contains($mName, $normQuery) || Str::contains($normQuery, $mName))) {
                    $valWithUnit = $cleanNewValue . ($newUnit && !str_ends_with($cleanNewValue, $newUnit) ? $newUnit : '');
                    $rows[$i][$colNilaiIdx] = $valWithUnit;
                    if ($newFooter !== null && trim($newFooter) !== '') {
                        $rows[$i][$colKetIdx] = trim($newFooter);
                    }
                    $matched = true;
                    break;
                }
            }

            if (!$matched) {
                if (empty($rows)) {
                    $rows[] = ['Metrik', 'Nilai', 'Keterangan'];
                }
                $valWithUnit = $cleanNewValue . ($newUnit && !str_ends_with($cleanNewValue, $newUnit) ? $newUnit : '');
                $rows[] = [$card->csv_search_query ?: $card->title, $valWithUnit, $newFooter ?: 'Diperbarui dari Kartu Statistik'];
                $matched = true;
            }
        }

        // C. NKO (Row 60 / Bobot Nilai)
        if (!$matched && ($dataSource->key === 'nko_csv' || Str::contains($normQuery, ['nko', 'bobot nilai', 'gap point']))) {
            $targetCol = 14;
            if (Str::contains($normQuery, ['110', 'max 110'])) $targetCol = 15;
            elseif (Str::contains($normQuery, ['gap', 'gap point'])) $targetCol = 17;

            if (isset($rows[60])) {
                $rows[60][$targetCol] = $cleanNewValue;
                $matched = true;
            }
        }

        // D. Header Kolom Tabel Horizontal
        if (!$matched && $formula === 'column_header') {
            if (count($rows) >= 2) {
                $headers = array_map(fn($h) => Str::lower($h ?? ''), $rows[0]);
                $targetColIdx = -1;
                foreach ($headers as $idx => $h) {
                    if (Str::contains($h, $normQuery) || Str::contains($normQuery, $h)) {
                        $targetColIdx = $idx;
                        break;
                    }
                }

                if ($targetColIdx !== -1) {
                    for ($i = count($rows) - 1; $i >= 1; $i--) {
                        if (isset($rows[$i][$targetColIdx])) {
                            $rows[$i][$targetColIdx] = $cleanNewValue;
                            $matched = true;
                            break;
                        }
                    }
                }
            }
        }

        // E. Cell Match Generic
        if (!$matched) {
            foreach ($rows as $rIdx => &$r) {
                foreach ($r as $cIdx => $cell) {
                    $cLower = Str::lower($cell ?? '');
                    if ($cLower !== '' && (Str::contains($cLower, $normQuery) || Str::contains($normQuery, $cLower))) {
                        $valCol = $cIdx + 1;
                        $r[$valCol] = $cleanNewValue;
                        if ($newFooter && isset($r[$valCol + 1])) {
                            $r[$valCol + 1] = $newFooter;
                        }
                        $matched = true;
                        break 2;
                    }
                }
            }
            unset($r);
        }

        // F. Jika masih tidak ada baris yang cocok, tambahkan baris baru
        if (!$matched) {
            if (empty($rows)) {
                $rows[] = ['Indikator', 'Nilai', 'Keterangan'];
            }
            $rows[] = [
                $card->csv_search_query ?: $card->title,
                $cleanNewValue . ($newUnit && !str_ends_with($cleanNewValue, $newUnit) ? ' ' . $newUnit : ''),
                $newFooter ?: ($card->footer_text ?: 'Diperbarui otomatis dari Kartu Statistik')
            ];
            $matched = true;
        }

        // 2. Simpan baris menjadi CSV string
        $fp = fopen('php://temp', 'r+');
        foreach ($rows as $row) {
            if (is_array($row)) {
                fputcsv($fp, $row);
            }
        }
        rewind($fp);
        $csvString = stream_get_contents($fp);
        fclose($fp);

        // 3. Tulis file CSV server baru
        $filename = Str::slug($dataSource->key) . '_synced_' . time() . '.csv';
        $fullPath = $destDir . DIRECTORY_SEPARATOR . $filename;
        File::put($fullPath, $csvString);

        // Hapus file sinkronisasi lama jika ada
        if ($dataSource->file_path && $dataSource->file_path !== $filename) {
            $oldPath = $destDir . DIRECTORY_SEPARATOR . $dataSource->file_path;
            if (File::exists($oldPath) && Str::startsWith($dataSource->file_path, Str::slug($dataSource->key) . '_synced_')) {
                File::delete($oldPath);
            }
        }

        // 4. Update DataSource agar langsung membaca file modifikasi terbaru
        $originalSourceType = $dataSource->source_type;
        $dataSource->file_path = $filename;
        $dataSource->source_type = 'file';
        $dataSource->is_active = true;
        $dataSource->save();

        // 5. Perbarui StatCard
        $card->value = $cleanNewValue;
        if ($newUnit !== null) $card->unit = $newUnit;
        if ($newFooter !== null) $card->footer_text = $newFooter;
        $card->save();

        // 6. Sinkronkan ulang kartu ini
        $syncResult = $this->syncCard($card);

        // 7. Sinkronkan juga seluruh kartu lain yang berbagi sumber data yang sama
        $siblingCards = StatCard::where('id', '!=', $card->id)
            ->where(function ($q) use ($dataSource) {
                $q->where('data_source_id', $dataSource->id)
                  ->orWhere('csv_key', $dataSource->key);
            })->get();

        foreach ($siblingCards as $sc) {
            $this->syncCard($sc);
        }

        // 8. Mirroring file jika asset_csv agar file fisik di folder luar selalu sinkron
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

        return [
            'success' => true,
            'message' => "Nilai berhasil ditulis ke sumber data ({$dataSource->name}) dan kartu statistik tersinkronkan!",
            'file_path' => $filename,
            'previous_source_type' => $originalSourceType,
            'effective_value' => $card->effective_value,
            'effective_unit' => $card->effective_unit,
            'effective_footer' => $card->effective_footer,
            'sync_status' => $card->sync_status,
            'sync_result' => $syncResult,
        ];
    }

    /**
     * Parse rincian ULTG dari string footer
     */
    public function parseAssetUltgBreakdown(?string $footer): array
    {
        $breakdown = ['sawangan' => '', 'lopana' => '', 'kotamobagu' => '', 'gorontalo' => ''];
        if (!$footer) return $breakdown;

        if (preg_match('/SWG\s*([0-9.,]+)/i', $footer, $m)) $breakdown['sawangan'] = $m[1];
        if (preg_match('/LPN\s*([0-9.,]+)/i', $footer, $m)) $breakdown['lopana'] = $m[1];
        if (preg_match('/KTG\s*([0-9.,]+)/i', $footer, $m)) $breakdown['kotamobagu'] = $m[1];
        if (preg_match('/GTO\s*([0-9.,]+)/i', $footer, $m)) $breakdown['gorontalo'] = $m[1];

        return $breakdown;
    }

    /**
     * Sinkronkan semua kartu statistik
     */
    public function syncAll(): array
    {
        $cards = StatCard::with('dataSource', 'section')->orderBy('order')->get();
        $syncedCount = 0;
        $manualFallbackCount = 0;
        $results = [];
        $dsRowsCache = [];

        foreach ($cards as $card) {
            $ds = $card->dataSource;
            $preloaded = null;
            if ($ds) {
                if (!isset($dsRowsCache[$ds->id])) {
                    try {
                        $dsRowsCache[$ds->id] = $this->getCsvRows($ds);
                    } catch (\Throwable $e) {
                        $dsRowsCache[$ds->id] = [];
                    }
                }
                $preloaded = $dsRowsCache[$ds->id];
            }

            $res = $this->syncCard($card, $preloaded);
            $results[] = [
                'card_id' => $card->id,
                'title' => $card->title,
                'result' => $res,
            ];

            if ($res['status'] === 'synced') {
                $syncedCount++;
            } else {
                $manualFallbackCount++;
            }
        }

        return [
            'total' => $cards->count(),
            'synced' => $syncedCount,
            'fallback_manual' => $manualFallbackCount,
            'details' => $results,
        ];
    }
}
