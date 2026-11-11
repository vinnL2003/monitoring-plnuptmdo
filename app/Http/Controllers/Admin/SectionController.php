<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::withCount(['statCards', 'progressItems'])
            ->orderBy('order')
            ->get();

        return view('admin.sections.index', compact('sections'));
    }

    public function edit(Section $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer',
            'is_visible' => 'sometimes|boolean',
        ]);

        $validated['is_visible'] = $request->has('is_visible');

        $section->update($validated);

        return redirect()->route('admin.sections.index')
            ->with('success', "Section '{$section->title}' berhasil diperbarui.");
    }

    public function toggle(Section $section)
    {
        $section->update([
            'is_visible' => !$section->is_visible,
        ]);

        $status = $section->is_visible ? 'ditampilkan' : 'disembunyikan';
        return back()->with('success', "Section '{$section->title}' sekarang {$status}.");
    }
}
