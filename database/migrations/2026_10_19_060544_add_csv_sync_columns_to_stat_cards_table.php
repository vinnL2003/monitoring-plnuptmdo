<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stat_cards', function (Blueprint $table) {
            $table->foreignId('data_source_id')->nullable()->constrained('data_sources')->onDelete('set null');
            $table->string('csv_key')->nullable()->after('css_class');
            $table->string('csv_search_query')->nullable()->after('csv_key');
            $table->string('csv_formula')->default('auto')->after('csv_search_query'); // auto, asset_param, metric_row, column_header
            $table->string('synced_value')->nullable()->after('csv_formula');
            $table->string('synced_unit')->nullable()->after('synced_value');
            $table->text('synced_footer')->nullable()->after('synced_unit');
            $table->timestamp('last_synced_at')->nullable()->after('synced_footer');
            $table->string('sync_status')->default('idle')->after('last_synced_at'); // idle, synced, fallback_manual, failed
            $table->text('sync_notes')->nullable()->after('sync_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stat_cards', function (Blueprint $table) {
            $table->dropForeign(['data_source_id']);
            $table->dropColumn([
                'data_source_id',
                'csv_key',
                'csv_search_query',
                'csv_formula',
                'synced_value',
                'synced_unit',
                'synced_footer',
                'last_synced_at',
                'sync_status',
                'sync_notes'
            ]);
        });
    }
};
