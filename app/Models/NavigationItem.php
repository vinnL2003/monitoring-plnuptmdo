<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationItem extends Model
{
    protected $fillable = ['label', 'url', 'icon', 'order', 'is_active', 'is_external'];

    protected $casts = [
        'is_active' => 'boolean',
        'is_external' => 'boolean',
        'order' => 'integer',
    ];
}
