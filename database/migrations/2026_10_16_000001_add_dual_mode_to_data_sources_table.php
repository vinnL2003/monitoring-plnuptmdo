<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_sources', function (Blueprint $table) {
            $table->string('source_type')->default('url')->after('key'); // 'url' or 'file'
            $table->string('file_path')->nullable()->after('url');
            $table->text('url')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('data_sources', function (Blueprint $table) {
            $table->dropColumn(['source_type', 'file_path']);
        });
    }
};
