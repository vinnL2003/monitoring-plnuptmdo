<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgressItem;
use App\Models\Section;
use Illuminate\Http\Request;

class ProgressItemController extends Controller
{
    public function index()
    {
        $sections = Section::with('progressItems')->orderBy('order')->get();
        return view('admin.progress_items.index', compact('sections'));
    }

    public function create()
    {
        $sections = Section::orderBy('order')->get();
        return view('admin.progress_items.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:20',
            'percentage' => 'required|numeric|min:0|max:100',
            'order' => 'required|integer',
        ]);

        ProgressItem::create($validated);

        return redirect()->route('admin.progress.index')
            ->with('success', 'Item progres berhasil ditambahkan.');
    }

    public function edit(ProgressItem $progress)
    {
        $sections = Section::orderBy('order')->get();
        return view('admin.progress_items.edit', [
            'progressItem' => $progress,
            'sections' => $sections,
        ]);
    }

    public function update(Request $request, ProgressItem $progress)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:20',
            'percentage' => 'required|numeric|min:0|max:100',
            'order' => 'required|integer',
        ]);

        $progress->update($validated);

        return redirect()->route('admin.progress.index')
            ->with('success', "Item progres '{$progress->title}' berhasil diperbarui.");
    }

    public function destroy(ProgressItem $progress)
    {
        $progress->delete();
        return redirect()->route('admin.progress.index')
            ->with('success', 'Item progres berhasil dihapus.');
    }
}
