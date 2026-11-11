<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_public_pages_are_accessible(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/login')->assertStatus(200);
        $this->get('/kinerja-transmisi')->assertStatus(200);
        $this->get('/anggaran')->assertStatus(200);
        $this->get('/ahi')->assertStatus(200);
        $this->get('/common-enemy')->assertStatus(200);
        $this->get('/abo')->assertStatus(200);
    }

    public function test_unauthenticated_user_cannot_access_admin(): void
    {
        $this->get('/admin/dashboard')->assertRedirect('/login');
    }

    public function test_admin_user_can_login_and_access_all_admin_modules(): void
    {
        $admin = User::where('email', 'admin@pln.co.id')->first();
        $this->assertNotNull($admin);

        $response = $this->post('/login', [
            'email' => 'admin@pln.co.id',
            'password' => 'admin123',
        ]);
        $response->assertRedirect('/admin/dashboard');

        // Test authenticated access to all modules
        $this->actingAs($admin)->get('/admin/dashboard')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/settings')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/sections')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/stat-cards')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/progress')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/data-sources')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/navigation')->assertStatus(200);
    }

    public function test_admin_can_update_settings(): void
    {
        $admin = User::where('email', 'admin@pln.co.id')->first();

        $response = $this->actingAs($admin)->post('/admin/settings', [
            'site_title' => 'DASHBOARD KINERJA PLN UPT MANADO (TERBARU)',
            'footer_text' => 'Hak Cipta Terpelihara 2026 PLN UPT Manado',
            'enable_live_clock' => '1',
        ]);

        $response->assertRedirect('/admin/settings');
        $this->assertDatabaseHas('site_settings', [
            'key' => 'site_title',
            'value' => 'DASHBOARD KINERJA PLN UPT MANADO (TERBARU)',
        ]);
    }
}
