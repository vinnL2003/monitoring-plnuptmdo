<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataSource;
use App\Models\Section;
use App\Models\StatCard;
use App\Services\CsvSyncService;
use Illuminate\Http\Request;

class StatCardController extends Controller
{
    protected CsvSyncService $syncService;

    public function __construct(CsvSyncService $syncService)
    {
        $this->syncService = $syncService;
    }

    public function index()
    {
        $sections = Section::with(['statCards' => function ($query) {
            $query->with('dataSource')->orderBy('order');
        }])->orderBy('order')->get();

        $totalCards = StatCard::count();
        $syncedCards = StatCard::where('sync_status', 'synced')->whereNotNull('synced_value')->count();
        $manualFallbackCards = $totalCards - $syncedCards;
        $dataSources = DataSource::where('is_active', true)->get();

        return view('admin.stat_cards.index', compact('sections', 'totalCards', 'syncedCards', 'manualFallbackCards', 'dataSources'));
    }

    public function create()
    {
        $sections = Section::orderBy('order')->get();
        $dataSources = DataSource::where('is_active', true)->get();
        return view('admin.stat_cards.create', compact('sections', 'dataSources'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'data_source_id' => 'nullable|exists:data_sources,id',
            'title' => 'required|string|max:255',
            'value' => 'nullable|string|max:100', // Nilai manual fallback
            'unit' => 'nullable|string|max:50',
            'icon' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'css_class' => 'nullable|string|max:50',
            'csv_key' => 'nullable|string|max:100',
            'csv_search_query' => 'nullable|string|max:255',
            'csv_formula' => 'nullable|string|in:auto,asset_param,metric_row,column_header,manual',
            'order' => 'required|integer',
        ]);

        if (!empty($validated['data_source_id']) && empty($validated['csv_key'])) {
            $ds = DataSource::find($validated['data_source_id']);
            if ($ds) {
                $validated['csv_key'] = $ds->key;
            }
        }

        $statCard = StatCard::create($validated);

        // Langsung coba sinkronkan dari CSV
        $syncResult = $this->syncService->syncCard($statCard);

        $msg = "Statistik '{$statCard->title}' berhasil ditambahkan. ";
        if ($syncResult['status'] === 'synced') {
            $msg .= "✅ Nilai berhasil disinkronkan dari CSV: '{$statCard->effective_value}' " . ($statCard->effective_unit ?? '');
        } else {
            $msg .= "ℹ️ Menggunakan nilai manual cadangan: '{$statCard->value}' (CSV belum terhubung atau bagian tidak ditemukan).";
        }

        return redirect()->route('admin.stat-cards.index')->with('success', $msg);
    }

    public function edit(StatCard $statCard)
    {
        $sections = Section::orderBy('order')->get();
        $dataSources = DataSource::where('is_active', true)->get();
        $ultgBreakdown = $this->syncService->parseAssetUltgBreakdown($statCard->effective_footer);

        return view('admin.stat_cards.edit', compact('statCard', 'sections', 'dataSources', 'ultgBreakdown'));
    }

    public function update(Request $request, StatCard $statCard)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'data_source_id' => 'nullable|exists:data_sources,id',
            'title' => 'required|string|max:255',
            'value' => 'nullable|string|max:100', // Nilai manual fallback
            'unit' => 'nullable|string|max:50',
            'icon' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'css_class' => 'nullable|string|max:50',
            'csv_key' => 'nullable|string|max:100',
            'csv_search_query' => 'nullable|string|max:255',
            'csv_formula' => 'nullable|string|in:auto,asset_param,metric_row,column_header,manual',
            'order' => 'required|integer',
            'sync_two_way' => 'nullable|boolean',
            'ultg_sawangan' => 'nullable|string|max:50',
            'ultg_lopana' => 'nullable|string|max:50',
            'ultg_kotamobagu' => 'nullable|string|max:50',
            'ultg_gorontalo' => 'nullable|string|max:50',
        ]);

        if (!empty($validated['data_source_id'])) {
            $ds = DataSource::find($validated['data_source_id']);
            if ($ds) {
                $validated['csv_key'] = $ds->key;
            }
        } else {
            $validated['csv_key'] = null;
        }

        $shouldSyncTwoWay = $request->boolean('sync_two_way') || $request->input('action_type') === 'save_sync_two_way';

        $statCard->update($validated);

        // Jika opsi Sinkronisasi 2-Arah diaktifkan (Tulis balik ke file CSV / Spreadsheet)
        if ($shouldSyncTwoWay && ($statCard->dataSource || $statCard->csv_key)) {
            $extra = [
                'sawangan' => $request->input('ultg_sawangan'),
                'lopana' => $request->input('ultg_lopana'),
                'kotamobagu' => $request->input('ultg_kotamobagu'),
                'gorontalo' => $request->input('ultg_gorontalo'),
            ];
            $writeRes = $this->syncService->writeBackToSource(
                $statCard,
                $validated['value'] ?? $statCard->value,
                $validated['unit'] ?? $statCard->unit,
                $validated['footer_text'] ?? $statCard->footer_text,
                $extra
            );

            $msg = "✅ Kartu '{$statCard->title}' & Sumber Data berhasil disinkronkan secara 2-arah! ";
            $msg .= "Nilai efektif: '{$statCard->effective_value}' " . ($statCard->effective_unit ?? '');
            if (!empty($writeRes['file_path'])) {
                $msg .= " (Tersimpan ke file CSV server '{$writeRes['file_path']}').";
            }

            return redirect()->route('admin.stat-cards.index')->with('success', $msg);
        }

        // Sinkronkan ulang dari CSV setelah diperbarui (1-arah standar)
        $syncResult = $this->syncService->syncCard($statCard);

        $msg = "Statistik '{$statCard->title}' berhasil diperbarui. ";
        if ($syncResult['status'] === 'synced') {
            $msg .= "✅ Nilai tersinkronkan dari CSV: '{$statCard->effective_value}' " . ($statCard->effective_unit ?? '');
        } else {
            $msg .= "ℹ️ Menggunakan Nilai Manual Cadangan: '{$statCard->value}' (" . ($syncResult['message'] ?? 'Data tidak ditemukan di CSV') . ").";
        }

        return redirect()->route('admin.stat-cards.index')->with('success', $msg);
    }

    /**
     * Ubah Cepat Nilai Kartu & Tulis Balik ke Sumber Data secara Instan (AJAX / Modal)
     */
    public function quickUpdate(Request $request, StatCard $statCard)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:100',
            'unit' => 'nullable|string|max:50',
            'footer_text' => 'nullable|string|max:255',
            'sync_two_way' => 'nullable|boolean',
            'ultg_sawangan' => 'nullable|string|max:50',
            'ultg_lopana' => 'nullable|string|max:50',
            'ultg_kotamobagu' => 'nullable|string|max:50',
            'ultg_gorontalo' => 'nullable|string|max:50',
        ]);

        $shouldSyncTwoWay = $request->boolean('sync_two_way', true);

        if ($shouldSyncTwoWay && ($statCard->dataSource || $statCard->csv_key)) {
            $extra = [
                'sawangan' => $request->input('ultg_sawangan'),
                'lopana' => $request->input('ultg_lopana'),
                'kotamobagu' => $request->input('ultg_kotamobagu'),
                'gorontalo' => $request->input('ultg_gorontalo'),
            ];
            $res = $this->syncService->writeBackToSource(
                $statCard,
                $validated['value'],
                $validated['unit'] ?? $statCard->unit,
                $validated['footer_text'] ?? $statCard->footer_text,
                $extra
            );
        } else {
            $statCard->value = $validated['value'];
            if (isset($validated['unit'])) $statCard->unit = $validated['unit'];
            if (isset($validated['footer_text'])) $statCard->footer_text = $validated['footer_text'];
            $statCard->save();
            $res = $this->syncService->syncCard($statCard);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Nilai kartu '{$statCard->title}' & Sumber Data berhasil diperbarui!",
                'card' => [
                    'id' => $statCard->id,
                    'title' => $statCard->title,
                    'effective_value' => $statCard->effective_value,
                    'effective_unit' => $statCard->effective_unit,
                    'effective_footer' => $statCard->effective_footer,
                    'sync_status' => $statCard->sync_status,
                    'is_synced' => $statCard->is_synced,
                    'source_type' => $statCard->dataSource?->source_type ?? 'none',
                    'file_path' => $statCard->dataSource?->file_path,
                ],
                'sync_result' => $res,
            ]);
        }

        return back()->with('success', "✅ Nilai kartu '{$statCard->title}' dan sumber data berhasil diperbarui secara 2-arah!");
    }

    /**
     * Kembalikan sumber data kartu ke live spreadsheet URL
     */
    public function resetToRemote(StatCard $statCard)
    {
        $ds = $statCard->dataSource;
        if ($ds && !empty($ds->url)) {
            $ds->source_type = 'url';
            $ds->save();
            $this->syncService->syncCard($statCard);
            return back()->with('success', "✅ Sumber data '{$ds->name}' telah dikembalikan membaca langsung dari Google Spreadsheet.");
        }

        return back()->with('warning', "Sumber data tidak memiliki URL spreadsheet live.");
    }

    public function destroy(StatCard $statCard)
    {
        $title = $statCard->title;
        $statCard->delete();
        return redirect()->route('admin.stat-cards.index')
            ->with('success', "Statistik '{$title}' berhasil dihapus.");
    }

    /**
     * Sinkronkan satu kartu statistik dari CSV
     */
    public function sync(StatCard $statCard)
    {
        $res = $this->syncService->syncCard($statCard);

        if ($res['status'] === 'synced') {
            return back()->with('success', "✅ Kartu '{$statCard->title}' tersinkronkan dari CSV: {$statCard->effective_value} " . ($statCard->effective_unit ?? ''));
        } else {
            return back()->with('warning', "ℹ️ {$res['message']}");
        }
    }

    /**
     * Sinkronkan semua kartu statistik dari CSV
     */
    public function syncAll()
    {
        $result = $this->syncService->syncAll();

        $msg = "Proses sinkronisasi selesai dari {$result['total']} kartu statistik: "
             . "{$result['synced']} kartu berhasil terbaca dari CSV, "
             . "{$result['fallback_manual']} kartu menggunakan nilai manual cadangan.";

        return back()->with('success', $msg);
    }

    /**
     * Uji coba pembacaan rumus / query CSV secara interaktif (AJAX)
     */
    public function testMapping(Request $request)
    {
        $request->validate([
            'data_source_id' => 'required|exists:data_sources,id',
            'csv_search_query' => 'required|string',
            'csv_formula' => 'nullable|string',
        ]);

        $dataSource = DataSource::findOrFail($request->input('data_source_id'));
        $query = $request->input('csv_search_query');
        $formula = $request->input('csv_formula') ?: 'auto';

        try {
            $rows = $this->syncService->getCsvRows($dataSource);
            $extracted = $this->syncService->extractValue($rows, $query, $formula);

            if ($extracted && !empty($extracted['value'])) {
                return response()->json([
                    'success' => true,
                    'found' => true,
                    'value' => $extracted['value'],
                    'unit' => $extracted['unit'] ?? '',
                    'footer' => $extracted['footer'] ?? '',
                    'matched_label' => $extracted['matched_label'] ?? $query,
                    'mode' => $extracted['mode'] ?? $formula,
                    'message' => "Bagian berhasil ditemukan di CSV: {$extracted['value']} " . ($extracted['unit'] ?? ''),
                ]);
            }

            return response()->json([
                'success' => true,
                'found' => false,
                'message' => "Bagian/Kolom '{$query}' tidak ditemukan dalam file CSV '{$dataSource->name}'. Jika disimpan, sistem akan menggunakan Nilai Manual sebagai cadangan.",
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'found' => false,
                'message' => "Gagal membaca file CSV: " . $e->getMessage(),
            ], 422);
        }
    }
}
