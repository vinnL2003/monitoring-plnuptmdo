<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', 'pln_logo_file', 'hero_logo_file']);

        // Handle PLN Logo upload if provided
        if ($request->hasFile('pln_logo_file')) {
            $file = $request->file('pln_logo_file');
            $filename = 'logo_pln_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $data['pln_logo'] = 'uploads/' . $filename;
        }

        // Handle UPT Logo upload if provided
        if ($request->hasFile('hero_logo_file')) {
            $file = $request->file('hero_logo_file');
            $filename = 'logo_upt_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $data['hero_logo'] = 'uploads/' . $filename;
        }

        // Ensure boolean fields are saved appropriately
        if (!isset($data['enable_live_clock'])) {
            $data['enable_live_clock'] = '0';
        }

        foreach ($data as $key => $value) {
            $setting = SiteSetting::where('key', $key)->first();
            if ($setting) {
                $setting->update(['value' => $value]);
            } else {
                SiteSetting::create([
                    'key' => $key,
                    'value' => $value,
                    'group' => 'general',
                    'label' => ucwords(str_replace('_', ' ', $key)),
                ]);
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan website berhasil diperbarui.');
    }
}
