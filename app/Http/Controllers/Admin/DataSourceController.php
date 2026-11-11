<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataSource;
use App\Models\StatCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DataSourceController extends Controller
{
    public function index()
    {
        $dataSources = DataSource::orderBy('created_at', 'asc')->get();
        return view('admin.data_sources.index', compact('dataSources'));
    }

    public function create()
    {
        return view('admin.data_sources.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:100|regex:/^[a-zA-Z0-9_]+$/|unique:data_sources,key',
            'source_type' => 'required|in:url,file,none',
            'url' => 'nullable|required_if:source_type,url',
            'csv_file' => 'nullable|required_if:source_type,file|file|max:15360',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ], [
            'key.regex' => 'Kode Identifier hanya boleh berisi huruf, angka, dan garis bawah (underscore), contoh: kku_csv.',
            'url.required_if' => 'URL Google Sheet wajib diisi bila memilih opsi Link Google Spreadsheet.',
            'csv_file.required_if' => 'File CSV wajib diunggah bila memilih opsi Upload File Lokal.',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($validated['source_type'] === 'none') {
            $validated['url'] = null;
            $validated['file_path'] = null;
        } elseif ($validated['source_type'] === 'file' && $request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            $ext = $file->getClientOriginalExtension() ?: 'csv';
            $filename = Str::slug($validated['key']) . '_' . time() . '.' . $ext;
            $destDir = public_path('uploads/data_sources');
            
            if (!File::isDirectory($destDir)) {
                File::makeDirectory($destDir, 0755, true, true);
            }

            $file->move($destDir, $filename);
            $validated['file_path'] = $filename;
            $validated['url'] = null;
        } elseif ($validated['source_type'] === 'url') {
            $validated['file_path'] = null;
        }

        DataSource::create($validated);

        return redirect()->route('admin.data-sources.index')
            ->with('success', "Sumber data baru '{$validated['name']}' berhasil ditambahkan.");
    }

    public function edit(DataSource $dataSource)
    {
        return view('admin.data_sources.edit', compact('dataSource'));
    }

    public function update(Request $request, DataSource $dataSource)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:100|regex:/^[a-zA-Z0-9_]+$/|unique:data_sources,key,' . $dataSource->id,
            'source_type' => 'required|in:url,file,none',
            'url' => 'nullable|required_if:source_type,url',
            'csv_file' => 'nullable|file|max:15360',
            'clear_file' => 'sometimes|boolean',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ], [
            'key.regex' => 'Kode Identifier hanya boleh berisi huruf, angka, dan garis bawah (underscore).',
            'url.required_if' => 'URL Google Sheet wajib diisi bila memilih opsi Link Google Spreadsheet.',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($validated['source_type'] === 'none') {
            $validated['url'] = null;
            if ($dataSource->file_path) {
                $oldPath = public_path('uploads/data_sources/' . $dataSource->file_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            $validated['file_path'] = null;
        } elseif ($validated['source_type'] === 'file') {
            $validated['url'] = null;
            if ($request->hasFile('csv_file')) {
                // Hapus file lama jika ada
                if ($dataSource->file_path) {
                    $oldPath = public_path('uploads/data_sources/' . $dataSource->file_path);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                $file = $request->file('csv_file');
                $ext = $file->getClientOriginalExtension() ?: 'csv';
                $filename = Str::slug($validated['key']) . '_' . time() . '.' . $ext;
                $destDir = public_path('uploads/data_sources');

                if (!File::isDirectory($destDir)) {
                    File::makeDirectory($destDir, 0755, true, true);
                }

                $file->move($destDir, $filename);
                $validated['file_path'] = $filename;
            } elseif ($request->boolean('clear_file')) {
                if ($dataSource->file_path) {
                    $oldPath = public_path('uploads/data_sources/' . $dataSource->file_path);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }
                $validated['file_path'] = null;
                return back()->withInput()->withErrors(['csv_file' => 'File CSV telah dihapus. Silakan unggah file baru atau pilih opsi Kosongkan.']);
            } elseif (!$dataSource->file_path) {
                return back()->withInput()->withErrors(['csv_file' => 'Harap unggah file CSV untuk sumber data ini.']);
            }
        } else {
            // source_type === 'url'
            if ($dataSource->file_path) {
                $oldPath = public_path('uploads/data_sources/' . $dataSource->file_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
                $validated['file_path'] = null;
            }
        }

        $dataSource->update($validated);

        // Jika sumber data dikosongkan atau dinonaktifkan, bersihkan nilai sinkronisasi StatCard terkait
        if ($validated['source_type'] === 'none' || !$validated['is_active']) {
            StatCard::where('data_source_id', $dataSource->id)
                ->orWhere('csv_key', $dataSource->key)
                ->update([
                    'synced_value' => null,
                    'synced_unit' => null,
                    'synced_footer' => null,
                    'sync_status' => 'idle',
                    'last_synced_at' => null,
                    'sync_notes' => 'Sumber data dikosongkan/dinonaktifkan oleh admin.',
                ]);
        } else {
            // Sinkronkan otomatis seluruh kartu yang menggunakan sumber data ini
            try {
                $syncService = app(\App\Services\CsvSyncService::class);
                $linkedCards = StatCard::where('data_source_id', $dataSource->id)
                    ->orWhere('csv_key', $dataSource->key)
                    ->get();
                foreach ($linkedCards as $card) {
                    $syncService->syncCard($card);
                }
            } catch (\Throwable $e) {}
        }

        return redirect()->route('admin.data-sources.index')
            ->with('success', "Sumber data '{$dataSource->name}' berhasil diperbarui dan seluruh kartu terkait disinkronkan.");
    }

    public function destroy(DataSource $dataSource)
    {
        // Hapus file fisik lokal jika ada
        if ($dataSource->file_path) {
            $path = public_path('uploads/data_sources/' . $dataSource->file_path);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        // Bersihkan sinkronisasi kartu statistik terkait
        StatCard::where('data_source_id', $dataSource->id)
            ->orWhere('csv_key', $dataSource->key)
            ->update([
                'synced_value' => null,
                'synced_unit' => null,
                'synced_footer' => null,
                'sync_status' => 'idle',
                'last_synced_at' => null,
                'sync_notes' => 'Sumber data dihapus oleh admin.',
            ]);

        $name = $dataSource->name;
        $dataSource->delete();

        return redirect()->route('admin.data-sources.index')
            ->with('success', "Sumber data '{$name}' berhasil dihapus.");
    }

    public function test(DataSource $dataSource)
    {
        try {
            if ($dataSource->source_type === 'none' || empty($dataSource->source_type)) {
                return back()->with('error', "Sumber data '{$dataSource->name}' saat ini berstatus Kosong / Tanpa Sumber Data (mode manual).");
            }

            if ($dataSource->source_type === 'file') {
                if (!$dataSource->file_path) {
                    return back()->with('error', "Belum ada file lokal yang diunggah untuk sumber data ini.");
                }

                $filePath = public_path('uploads/data_sources/' . $dataSource->file_path);
                if (!File::exists($filePath)) {
                    return back()->with('error', "File lokal '{$dataSource->file_path}' tidak ditemukan di server.");
                }

                $content = File::get($filePath);
                $bytes = strlen($content);
                $firstLines = array_slice(explode("\n", trim($content)), 0, 4);

                return back()->with('success', "File lokal aktif! Ditemukan " . number_format($bytes) . " bytes data.\nSample isi data:\n" . implode("\n", $firstLines));
            }

            // Mode URL Google Sheet
            if (!$dataSource->url) {
                return back()->with('error', "URL sumber data belum diisi.");
            }

            $response = Http::withoutVerifying()->timeout(15)->get($dataSource->url);
            if ($response->successful()) {
                $bytes = strlen($response->body());
                $firstLines = array_slice(explode("\n", trim($response->body())), 0, 4);
                return back()->with('success', "Koneksi Google Sheets berhasil! Diterima " . number_format($bytes) . " bytes data.\nSample isi data:\n" . implode("\n", $firstLines));
            } else {
                return back()->with('error', "Gagal menghubungi Google Sheet: HTTP {$response->status()}");
            }
        } catch (\Exception $e) {
            return back()->with('error', "Gagal terhubung: " . $e->getMessage());
        }
    }
}
