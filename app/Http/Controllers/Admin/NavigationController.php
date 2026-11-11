<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index()
    {
        $navItems = NavigationItem::orderBy('order')->get();
        return view('admin.navigation.index', compact('navItems'));
    }

    public function create()
    {
        return view('admin.navigation.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'order' => 'required|integer',
            'is_active' => 'sometimes|boolean',
            'is_external' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_external'] = $request->has('is_external');

        NavigationItem::create($validated);

        return redirect()->route('admin.navigation.index')
            ->with('success', 'Menu navigasi baru berhasil ditambahkan.');
    }

    public function edit(NavigationItem $navigation)
    {
        return view('admin.navigation.edit', [
            'navItem' => $navigation,
        ]);
    }

    public function update(Request $request, NavigationItem $navigation)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'order' => 'required|integer',
            'is_active' => 'sometimes|boolean',
            'is_external' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_external'] = $request->has('is_external');

        $navigation->update($validated);

        return redirect()->route('admin.navigation.index')
            ->with('success', "Menu navigasi '{$navigation->label}' berhasil diperbarui.");
    }

    public function destroy(NavigationItem $navigation)
    {
        $navigation->delete();
        return redirect()->route('admin.navigation.index')
            ->with('success', 'Menu navigasi berhasil dihapus.');
    }
}
