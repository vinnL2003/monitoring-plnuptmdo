<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageAccessSetting extends Model
{
    protected $fillable = [
        'page_slug',
        'page_name',
        'page_url',
        'icon',
        'is_restricted',
        'description',
    ];

    protected $casts = [
        'is_restricted' => 'boolean',
    ];

    public static function isPageRestricted(string $slug): bool
    {
        $setting = static::where('page_slug', $slug)->first();
        return $setting ? (bool) $setting->is_restricted : false;
    }
}
