<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $fillable = ['page', 'slug', 'title', 'description', 'icon', 'order', 'is_visible'];

    protected $casts = [
        'is_visible' => 'boolean',
        'order' => 'integer',
    ];

    public function statCards(): HasMany
    {
        return $this->hasMany(StatCard::class)->orderBy('order');
    }

    public function progressItems(): HasMany
    {
        return $this->hasMany(ProgressItem::class)->orderBy('order');
    }
}
