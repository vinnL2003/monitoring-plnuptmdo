<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageAccessAccount;
use App\Models\PageAccessSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PageAccessController extends Controller
{
    public function index()
    {
        $settings = PageAccessSetting::orderBy('id')->get();
        $accounts = PageAccessAccount::orderBy('name')->get();

        return view('admin.page_access.index', compact('settings', 'accounts'));
    }

    public function toggleSetting(Request $request, string $slug)
    {
        $setting = PageAccessSetting::where('page_slug', $slug)->firstOrFail();
        $setting->is_restricted = !$setting->is_restricted;
        $setting->save();

        if ($setting->is_restricted) {
            session()->forget('page_unlocked_' . $slug);
            session()->forget('page_unlocked_at_' . $slug);
            session()->forget('page_last_activity_' . $slug);
            session()->forget('page_locked_reason_' . $slug);
            if ($slug === 'anggaran') {
                session()->forget('anggaran_unlocked');
            }
        }

        $statusText = $setting->is_restricted ? 'AKTIF (Wajib Login)' : 'NONAKTIF (Publik / Tanpa Login)';

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_restricted' => $setting->is_restricted,
                'message' => "Mode akses khusus halaman '{$setting->page_name}' sekarang {$statusText}."
            ]);
        }

        return redirect()->route('admin.page-access.index')
            ->with('success', "Mode akses khusus halaman '{$setting->page_name}' sekarang {$statusText}.");
    }

    public function createAccount()
    {
        $pages = PageAccessSetting::orderBy('id')->get();
        return view('admin.page_access.account_create', compact('pages'));
    }

    public function storeAccount(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:page_access_accounts,username'],
            'password' => ['required', 'string', 'min:4'],
            'allowed_pages' => ['required', 'array', 'min:1'],
            'is_active' => ['nullable'],
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'name.required' => 'Nama personil / pemegang akun wajib diisi.',
            'username.required' => 'Username / NIP login wajib diisi.',
            'username.unique' => 'Username / NIP tersebut sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 4 karakter.',
            'allowed_pages.required' => 'Pilih minimal satu halaman yang diizinkan untuk diakses.',
        ]);

        PageAccessAccount::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'allowed_pages' => $validated['allowed_pages'],
            'is_active' => $request->has('is_active'),
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.page-access.index')
            ->with('success', "Akun personil '{$validated['name']}' berhasil ditambahkan.");
    }

    public function editAccount(PageAccessAccount $account)
    {
        $pages = PageAccessSetting::orderBy('id')->get();
        return view('admin.page_access.account_edit', compact('account', 'pages'));
    }

    public function updateAccount(Request $request, PageAccessAccount $account)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('page_access_accounts', 'username')->ignore($account->id)],
            'password' => ['nullable', 'string', 'min:4'],
            'allowed_pages' => ['required', 'array', 'min:1'],
            'is_active' => ['nullable'],
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'name.required' => 'Nama personil / pemegang akun wajib diisi.',
            'username.required' => 'Username / NIP login wajib diisi.',
            'username.unique' => 'Username / NIP tersebut sudah digunakan oleh akun lain.',
            'password.min' => 'Password minimal 4 karakter jika ingin diubah.',
            'allowed_pages.required' => 'Pilih minimal satu halaman yang diizinkan untuk diakses.',
        ]);

        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'allowed_pages' => $validated['allowed_pages'],
            'is_active' => $request->has('is_active'),
            'notes' => $validated['notes'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $account->update($data);

        return redirect()->route('admin.page-access.index')
            ->with('success', "Data akun personil '{$account->name}' berhasil diperbarui.");
    }

    public function toggleAccount(PageAccessAccount $account)
    {
        $account->is_active = !$account->is_active;
        $account->save();

        $statusText = $account->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.page-access.index')
            ->with('success', "Akun personil '{$account->name}' berhasil {$statusText}.");
    }

    public function destroyAccount(PageAccessAccount $account)
    {
        $name = $account->name;
        $account->delete();

        return redirect()->route('admin.page-access.index')
            ->with('success', "Akun personil '{$name}' berhasil dihapus.");
    }
}
