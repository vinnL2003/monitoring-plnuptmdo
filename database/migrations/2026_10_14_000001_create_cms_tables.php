<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Site-wide key-value settings
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general'); // general, branding, footer, seo
            $table->string('type')->default('text'); // text, textarea, image, boolean
            $table->string('label')->nullable();
            $table->timestamps();
        });

        // Navigation items
        Schema::create('navigation_items', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('url');
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_external')->default(false);
            $table->timestamps();
        });

        // Content sections (the numbered sections on the dashboard)
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('page')->default('home'); // home, kinerja, anggaran, ahi, common-enemy, abo
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        // Stat cards (NKO, assets, KKU, etc.)
        Schema::create('stat_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->string('title');
            $table->string('value')->nullable();
            $table->string('unit')->nullable();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->text('footer_text')->nullable();
            $table->string('css_class')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Progress items (construction, penyaluran, etc.)
        Schema::create('progress_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->decimal('percentage', 5, 2)->default(0);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Configurable data sources (Google Sheets URLs)
        Schema::create('data_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key')->unique(); // nko_csv, ahi_csv, etc.
            $table->text('url');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_sources');
        Schema::dropIfExists('progress_items');
        Schema::dropIfExists('stat_cards');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('navigation_items');
        Schema::dropIfExists('site_settings');
    }
};
