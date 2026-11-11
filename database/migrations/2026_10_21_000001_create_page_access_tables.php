<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Settings status akses khusus tiap halaman publik
        Schema::create('page_access_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page_slug')->unique(); // e.g. anggaran, kinerja-transmisi, aset, ahi, etc.
            $table->string('page_name');           // e.g. Anggaran Unit
            $table->string('page_url');            // e.g. /anggaran
            $table->string('icon')->nullable();    // e.g. 💰
            $table->boolean('is_restricted')->default(false); // Mode akses terbatas aktif/tidak
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Akun personil akses khusus tiap halaman
        Schema::create('page_access_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');                // Nama personil / jabatan
            $table->string('username')->unique();  // Username / NIP
            $table->string('password');            // Password terenkripsi bcrypt
            $table->json('allowed_pages')->nullable(); // Array slug halaman yang diizinkan, misal ["anggaran"] atau ["*"]
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_access_accounts');
        Schema::dropIfExists('page_access_settings');
    }
};
