<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageAccessAccount extends Model
{
    protected $fillable = [
        'name',
        'username',
        'password',
        'allowed_pages',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'allowed_pages' => 'array',
        'is_active' => 'boolean',
    ];

    public function hasAccessToPage(string $slug): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $pages = $this->allowed_pages ?? [];
        if (in_array('*', $pages, true)) {
            return true;
        }

        return in_array($slug, $pages, true);
    }
}
