<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatCard extends Model
{
    protected $fillable = [
        'section_id',
        'data_source_id',
        'title',
        'value',
        'unit',
        'icon',
        'description',
        'footer_text',
        'css_class',
        'csv_key',
        'csv_search_query',
        'csv_formula',
        'synced_value',
        'synced_unit',
        'synced_footer',
        'last_synced_at',
        'sync_status',
        'sync_notes',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
        'last_synced_at' => 'datetime',
    ];

    protected $appends = [
        'effective_value',
        'effective_unit',
        'effective_footer',
        'is_synced',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function dataSource(): BelongsTo
    {
        return $this->belongsTo(DataSource::class);
    }

    public function getResolvedDataSource(): ?DataSource
    {
        if ($this->relationLoaded('dataSource') && $this->dataSource) {
            return $this->dataSource;
        }
        if ($this->data_source_id) {
            return $this->dataSource ?: DataSource::find($this->data_source_id);
        }
        if ($this->csv_key) {
            return DataSource::where('key', $this->csv_key)->first();
        }
        return null;
    }

    /**
     * Mengambil nilai efektif: prioritaskan hasil baca CSV jika berstatus synced,
     * jika sumber data dikosongkan/dinonaktifkan kembalikan '-', atau fallback manual.
     */
    public function getEffectiveValueAttribute(): string
    {
        $ds = $this->getResolvedDataSource();
        if ($ds) {
            if (!$ds->is_active || $ds->source_type === 'none' || empty($ds->effective_url)) {
                return '-';
            }
        }

        if ($this->sync_status === 'synced' && !empty($this->synced_value)) {
            return $this->synced_value;
        }

        return (string) ($this->value ?? '-');
    }

    /**
     * Satuan efektif: dari CSV jika ada, fallback ke manual unit
     */
    public function getEffectiveUnitAttribute(): string
    {
        $ds = $this->getResolvedDataSource();
        if ($ds) {
            if (!$ds->is_active || $ds->source_type === 'none' || empty($ds->effective_url)) {
                return '';
            }
        }

        if ($this->sync_status === 'synced' && !empty($this->synced_unit)) {
            return $this->synced_unit;
        }
        return (string) ($this->unit ?? '');
    }

    /**
     * Keterangan footer efektif: dari CSV jika ada, fallback ke manual footer_text
     */
    public function getEffectiveFooterAttribute(): string
    {
        $ds = $this->getResolvedDataSource();
        if ($ds) {
            if (!$ds->is_active || $ds->source_type === 'none' || empty($ds->effective_url)) {
                return 'Menunggu sumber data...';
            }
        }

        if ($this->sync_status === 'synced' && !empty($this->synced_footer)) {
            return $this->synced_footer;
        }
        return (string) ($this->footer_text ?? 'Menunggu data...');
    }

    /**
     * Status apakah saat ini aktif menggunakan data dari CSV
     */
    public function getIsSyncedAttribute(): bool
    {
        $ds = $this->getResolvedDataSource();
        if ($ds && (!$ds->is_active || $ds->source_type === 'none' || empty($ds->effective_url))) {
            return false;
        }

        return $this->sync_status === 'synced' && !empty($this->synced_value);
    }
}
