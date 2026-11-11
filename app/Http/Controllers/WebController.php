<?php

namespace App\Http\Controllers;

use App\Models\DataSource;
use App\Models\NavigationItem;
use App\Models\PageAccessAccount;
use App\Models\PageAccessSetting;
use App\Models\Section;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebController extends Controller
{
    protected function getSharedData(): array
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
        $navItems = NavigationItem::where('is_active', true)->orderBy('order')->get();
        $dataSources = DataSource::all()->mapWithKeys(function ($ds) {
            $hasValid = $ds->is_active && $ds->source_type !== 'none' && !empty($ds->effective_url);
            return [$ds->key => $hasValid ? $ds->effective_url : ''];
        })->toArray();

        return compact('settings', 'navItems', 'dataSources');
    }

    protected function forgetPageUnlockSession(string $slug, string $reason = 'manual'): void
    {
        session()->forget('page_unlocked_' . $slug);
        session()->forget('page_unlocked_at_' . $slug);
        session()->forget('page_last_activity_' . $slug);
        session()->forget('page_unlocked_type_' . $slug);
        session()->forget('page_unlocked_account_id_' . $slug);
        session()->forget('page_unlocked_account_username_' . $slug);
        session()->forget('page_unlocked_user_id_' . $slug);

        if ($slug === 'anggaran') {
            session()->forget('anggaran_unlocked');
            session()->forget('anggaran_unlocked_type');
            session()->forget('anggaran_unlocked_account_id');
            session()->forget('anggaran_unlocked_account_username');
            session()->forget('anggaran_unlocked_user_id');
        }

        session(['page_locked_reason_' . $slug => $reason]);
    }

    protected function isAccountStillValid(string $slug): bool
    {
        $unlockedType = session('page_unlocked_type_' . $slug);
        if ($slug === 'anggaran' && empty($unlockedType)) {
            $unlockedType = session('anggaran_unlocked_type');
        }

        // Jika di-unlock oleh admin web
        if ($unlockedType === 'admin') {
            $userId = session('page_unlocked_user_id_' . $slug) ?? session('anggaran_unlocked_user_id');
            if ($userId) {
                return User::where('id', $userId)->exists();
            }
            return true;
        }

        // Jika di-unlock oleh akun personil terbatas (PageAccessAccount)
        $accountId = session('page_unlocked_account_id_' . $slug);
        if ($slug === 'anggaran' && empty($accountId)) {
            $accountId = session('anggaran_unlocked_account_id');
        }

        if ($accountId) {
            $account = PageAccessAccount::find($accountId);
            if (!$account || !$account->is_active || !$account->hasAccessToPage($slug)) {
                return false;
            }
            return true;
        }

        // Fallback jika hanya tercatat username
        $username = session('page_unlocked_account_username_' . $slug) ?? session('anggaran_unlocked_account_username');
        if ($username) {
            $account = PageAccessAccount::where('username', $username)->first();
            if (!$account || !$account->is_active || !$account->hasAccessToPage($slug)) {
                return false;
            }
            return true;
        }

        return true;
    }

    protected function getPageAccessInfo(string $slug): array
    {
        $isRestricted = PageAccessSetting::isPageRestricted($slug);
        $pageSetting = PageAccessSetting::where('page_slug', $slug)->first();
        $pageTitle = $pageSetting ? $pageSetting->page_name : ucwords(str_replace('-', ' ', $slug));
        $lockedReason = session('page_locked_reason_' . $slug, null);

        // Jika halaman tidak dibatasi, otomatis unlocked
        if (!$isRestricted) {
            $isUnlocked = true;
            $lockedReason = null;
        } else {
            $unlockedAt = (int) session('page_unlocked_at_' . $slug, 0);
            $settingUpdatedAt = ($pageSetting && $pageSetting->updated_at) ? $pageSetting->updated_at->timestamp : 0;
            $isSessionUnlocked = (bool) (session('page_unlocked_' . $slug, false) 
                || ($slug === 'anggaran' && session('anggaran_unlocked', false)));

            // Jika setting proteksi baru diaktifkan/diubah setelah sesi di-unlock, batalkan unlock sesi lama
            if ($isSessionUnlocked && ($unlockedAt == 0 || ($settingUpdatedAt > 0 && $unlockedAt < $settingUpdatedAt))) {
                $isSessionUnlocked = false;
                $this->forgetPageUnlockSession($slug, 'manual');
            }

            // CEK STATUS AKUN: Jika akun dinonaktifkan/dihapus/hak akses dicabut oleh admin
            if ($isSessionUnlocked && !$this->isAccountStillValid($slug)) {
                $isSessionUnlocked = false;
                $this->forgetPageUnlockSession($slug, 'account_deactivated');
                $isUnlocked = false;
                $lockedReason = 'account_deactivated';
            }

            // Timeout 10 menit (600 detik) jika halaman tidak dibuka / tidak ada aktivitas
            $lastActivity = session('page_last_activity_' . $slug, 0);
            $unopenedLimit = 600;
            if (request()->has('test_unopened_sec') && app()->environment('local')) {
                $unopenedLimit = (int) request()->input('test_unopened_sec');
            }

            if ($isSessionUnlocked && $lastActivity > 0 && ((time() - $lastActivity) >= $unopenedLimit)) {
                $this->forgetPageUnlockSession($slug, 'unopened_10m');
                $isUnlocked = false;
                $lockedReason = 'unopened_10m';
            } else {
                $isUnlocked = $isSessionUnlocked;
                if ($isUnlocked) {
                    session(['page_last_activity_' . $slug => time()]);
                } else {
                    $lockedReason = session('page_locked_reason_' . $slug, 'manual');
                }
            }
        }

        return [
            'pageSlug' => $slug,
            'pageTitle' => $pageTitle,
            'isRestricted' => $isRestricted,
            'isUnlocked' => (bool) $isUnlocked,
            'lockedReason' => $lockedReason,
        ];
    }

    public function index()
    {
        $shared = $this->getSharedData();
        $sections = Section::with(['statCards.dataSource', 'progressItems'])
            ->where('page', 'home')
            ->where('is_visible', true)
            ->orderBy('order')
            ->get()
            ->keyBy('slug');

        return view('pages.home', array_merge($shared, compact('sections')));
    }

    public function kinerjaTransmisi()
    {
        $shared = $this->getSharedData();
        $access = $this->getPageAccessInfo('kinerja-transmisi');
        return view('pages.kinerja-transmisi', array_merge($shared, $access));
    }

    public function anggaran()
    {
        $shared = $this->getSharedData();
        $access = $this->getPageAccessInfo('anggaran');
        return view('pages.anggaran', array_merge($shared, $access));
    }

    public function verifyAnggaranAccess(Request $request)
    {
        // Wrapper for backward compatibility
        $request->merge(['page_slug' => 'anggaran']);
        return $this->verifyPageAccess($request);
    }

    public function lockAnggaranAccess(Request $request)
    {
        // Wrapper for backward compatibility
        $request->merge(['page_slug' => 'anggaran']);
        return $this->lockPageAccess($request);
    }

    public function verifyPageAccess(Request $request)
    {
        $slug = trim((string) $request->input('page_slug', 'anggaran'));
        $username = trim((string) $request->input('username', ''));
        $password = (string) $request->input('password', '');

        if (empty($username) || empty($password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username dan password wajib diisi.'
            ], 422);
        }

        // 1. Cek Akun Admin Web di Database (email atau nama)
        $adminUser = User::where('email', $username)->orWhere('name', $username)->first();
        if ($adminUser && Hash::check($password, $adminUser->password)) {
            session([
                'page_unlocked_' . $slug => true,
                'page_unlocked_at_' . $slug => time(),
                'page_last_activity_' . $slug => time(),
                'page_unlocked_type_' . $slug => 'admin',
                'page_unlocked_user_id_' . $slug => $adminUser->id,
            ]);
            session()->forget('page_locked_reason_' . $slug);
            if ($slug === 'anggaran') {
                session([
                    'anggaran_unlocked' => true,
                    'anggaran_unlocked_type' => 'admin',
                    'anggaran_unlocked_user_id' => $adminUser->id,
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'Autentikasi Administrator berhasil.'
            ]);
        }

        // 2. Cek Akun Personil Berwenang Terdaftar di Database (Tabel page_access_accounts)
        $account = PageAccessAccount::where('username', $username)->first();
        if ($account && Hash::check($password, $account->password)) {
            if (!$account->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun personil ini sedang dinonaktifkan. Hubungi administrator.'
                ], 403);
            }

            if ($account->hasAccessToPage($slug)) {
                session([
                    'page_unlocked_' . $slug => true,
                    'page_unlocked_at_' . $slug => time(),
                    'page_last_activity_' . $slug => time(),
                    'page_unlocked_type_' . $slug => 'account',
                    'page_unlocked_account_id_' . $slug => $account->id,
                    'page_unlocked_account_username_' . $slug => $account->username,
                ]);
                session()->forget('page_locked_reason_' . $slug);
                if ($slug === 'anggaran') {
                    session([
                        'anggaran_unlocked' => true,
                        'anggaran_unlocked_type' => 'account',
                        'anggaran_unlocked_account_id' => $account->id,
                        'anggaran_unlocked_account_username' => $account->username,
                    ]);
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Autentikasi personil berhasil.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda aktif namun tidak memiliki hak akses untuk halaman ini.'
                ], 403);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Username atau password salah. Silakan periksa kembali kredensial Anda.'
        ], 422);
    }

    public function lockPageAccess(Request $request)
    {
        $slug = trim((string) $request->input('page_slug', 'anggaran'));
        $reason = trim((string) $request->input('reason', 'manual'));

        $this->forgetPageUnlockSession($slug, $reason);

        return response()->json([
            'success' => true,
            'reason' => $reason,
            'message' => "Akses halaman {$slug} telah dikunci kembali."
        ]);
    }

    public function pingPageAccess(Request $request)
    {
        $slug = trim((string) $request->input('page_slug', 'anggaran'));

        $isRestricted = PageAccessSetting::isPageRestricted($slug);
        if (!$isRestricted) {
            return response()->json(['success' => true, 'unlocked' => true, 'restricted' => false]);
        }

        $pageSetting = PageAccessSetting::where('page_slug', $slug)->first();
        $settingUpdatedAt = ($pageSetting && $pageSetting->updated_at) ? $pageSetting->updated_at->timestamp : 0;
        $unlockedAt = (int) session('page_unlocked_at_' . $slug, 0);

        $isUnlocked = (bool) (session('page_unlocked_' . $slug, false) 
            || ($slug === 'anggaran' && session('anggaran_unlocked', false)));

        // 1. Jika proteksi baru diaktifkan/diubah setelah sesi di-unlock, batalkan unlock sesi lama
        if ($isUnlocked && ($unlockedAt == 0 || ($settingUpdatedAt > 0 && $unlockedAt < $settingUpdatedAt))) {
            $isUnlocked = false;
            $this->forgetPageUnlockSession($slug, 'manual');
            return response()->json([
                'success' => false,
                'unlocked' => false,
                'locked' => true,
                'restricted' => true,
                'reason' => 'manual',
                'message' => 'Proteksi akses baru saja diaktifkan kembali oleh administrator.'
            ], 401);
        }

        // 2. CEK STATUS AKUN: Jika akun dinonaktifkan/dihapus/hak akses dicabut oleh admin
        if ($isUnlocked && !$this->isAccountStillValid($slug)) {
            $isUnlocked = false;
            $this->forgetPageUnlockSession($slug, 'account_deactivated');
            return response()->json([
                'success' => false,
                'unlocked' => false,
                'locked' => true,
                'restricted' => true,
                'reason' => 'account_deactivated',
                'message' => 'Akun personil telah dinonaktifkan oleh administrator.'
            ], 403);
        }

        if (!$isUnlocked) {
            return response()->json([
                'success' => false,
                'unlocked' => false,
                'locked' => true,
                'restricted' => true,
                'reason' => session('page_locked_reason_' . $slug, 'manual')
            ], 401);
        }

        $lastActivity = session('page_last_activity_' . $slug, 0);
        $unopenedLimit = 600; // 10 menit
        if ($request->has('test_unopened_sec') && app()->environment('local')) {
            $unopenedLimit = (int) $request->input('test_unopened_sec');
        }

        if ($lastActivity > 0 && ((time() - $lastActivity) >= $unopenedLimit)) {
            $this->forgetPageUnlockSession($slug, 'unopened_10m');

            return response()->json([
                'success' => false,
                'unlocked' => false,
                'locked' => true,
                'restricted' => true,
                'reason' => 'unopened_10m'
            ], 401);
        }

        // Perbarui timestamp aktivitas di server
        session(['page_last_activity_' . $slug => time()]);

        return response()->json([
            'success' => true,
            'unlocked' => true,
            'restricted' => true
        ]);
    }

    public function ahi()
    {
        $shared = $this->getSharedData();
        $access = $this->getPageAccessInfo('ahi');
        return view('pages.ahi', array_merge($shared, $access));
    }

    public function commonEnemy()
    {
        $shared = $this->getSharedData();
        $access = $this->getPageAccessInfo('common-enemy');
        return view('pages.common-enemy', array_merge($shared, $access));
    }

    public function abo()
    {
        $shared = $this->getSharedData();
        $access = $this->getPageAccessInfo('abo');
        return view('pages.abo', array_merge($shared, $access));
    }

    public function aset()
    {
        $shared = $this->getSharedData();
        $access = $this->getPageAccessInfo('aset');
        $sections = Section::with(['statCards.dataSource', 'progressItems'])
            ->where('is_visible', true)
            ->get()
            ->keyBy('slug');

        return view('pages.aset', array_merge($shared, compact('sections'), $access));
    }

    public function konstruksiPenyaluran()
    {
        $shared = $this->getSharedData();
        $access = $this->getPageAccessInfo('konstruksi-penyaluran');
        $sections = Section::with(['statCards.dataSource', 'progressItems'])
            ->where('is_visible', true)
            ->get()
            ->keyBy('slug');

        return view('pages.konstruksi-penyaluran', array_merge($shared, compact('sections'), $access));
    }

    public function kku()
    {
        $shared = $this->getSharedData();
        $access = $this->getPageAccessInfo('kku');
        $sections = Section::with(['statCards.dataSource', 'progressItems'])
            ->where('is_visible', true)
            ->get()
            ->keyBy('slug');

        return view('pages.kku', array_merge($shared, compact('sections'), $access));
    }

    public function proxyCsv(Request $request)
    {
        $url = $request->query('url');
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return response('URL tidak valid', 400);
        }

        $cacheKey = 'proxy_csv_' . md5($url);
        if ($request->query('refresh') === '1') {
            \Illuminate\Support\Facades\Cache::forget($cacheKey);
        }

        try {
            $body = \Illuminate\Support\Facades\Cache::remember($cacheKey, 180, function () use ($url) {
                $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                    ->timeout(12)
                    ->get($url);

                if ($response->successful()) {
                    return $response->body();
                }
                return null;
            });

            if ($body !== null) {
                return response($body, 200, [
                    'Content-Type' => 'text/plain; charset=UTF-8',
                    'Access-Control-Allow-Origin' => '*',
                    'Cache-Control' => 'public, max-age=180',
                ]);
            }
            return response('Gagal mengambil data dari Google Sheets', 502);
        } catch (\Exception $e) {
            return response('Gagal terhubung ke sumber data: ' . $e->getMessage(), 500);
        }
    }
}
