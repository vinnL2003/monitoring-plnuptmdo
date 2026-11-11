<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class DataSource extends Model
{
    protected $fillable = [
        'name',
        'key',
        'source_type', // 'url' or 'file'
        'url',
        'file_path',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['effective_url'];

    public function getEffectiveUrlAttribute(): string
    {
        if ($this->source_type === 'file' && $this->file_path) {
            $path = public_path('uploads/data_sources/' . $this->file_path);
            $v = File::exists($path) ? File::lastModified($path) : time();
            return '/uploads/data_sources/' . $this->file_path . '?v=' . $v;
        }
        if ($this->source_type === 'none' || empty($this->source_type)) {
            return '';
        }
        return $this->url ?? '';
    }

    public static function getUrl(string $key, string $default = ''): string
    {
        $source = static::where('key', $key)->where('is_active', true)->first();
        return $source ? $source->effective_url : $default;
    }
}

