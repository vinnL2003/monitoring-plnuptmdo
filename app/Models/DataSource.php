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

    /**
     * Konversi otomatis link Google Spreadsheet biasa (/edit, share, /pubhtml)
     * menjadi link endpoint data CSV resmi Google
     */
    public static function normalizeGoogleUrl(?string $url): string
    {
        if (empty($url)) {
            return '';
        }
        $url = trim($url);

        // Jika sudah berformat CSV, biarkan
        if (str_contains($url, 'output=csv') || str_contains($url, 'format=csv')) {
            return $url;
        }

        // 1. Tautan standar browser Google Docs:
        // https://docs.google.com/spreadsheets/d/{ID}/edit#gid={GID}
        if (preg_match('#docs\.google\.com/spreadsheets/d/([a-zA-Z0-9_-]+)#', $url, $matches)) {
            $spreadsheetId = $matches[1];
            // Lewati jika prefix publik '/d/e/'
            if ($spreadsheetId !== 'e') {
                $gid = '0';
                if (preg_match('/[#&?]gid=([0-9]+)/', $url, $gidMatch)) {
                    $gid = $gidMatch[1];
                }
                return "https://docs.google.com/spreadsheets/d/{$spreadsheetId}/export?format=csv&gid={$gid}";
            }
        }

        // 2. Tautan Publish HTML (/pubhtml) -> ubah ke /pub?output=csv
        if (str_contains($url, '/pubhtml')) {
            return str_replace('/pubhtml', '/pub?output=csv', $url);
        }

        return $url;
    }

    public function setUrlAttribute($value): void
    {
        $this->attributes['url'] = static::normalizeGoogleUrl($value);
    }

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
        return static::normalizeGoogleUrl($this->url ?? '');
    }

    public static function getUrl(string $key, string $default = ''): string
    {
        $source = static::where('key', $key)->where('is_active', true)->first();
        return $source ? $source->effective_url : $default;
    }
}

