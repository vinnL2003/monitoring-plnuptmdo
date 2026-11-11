<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgressItem extends Model
{
    protected $fillable = [
        'section_id',
        'title',
        'description',
        'icon',
        'percentage',
        'order',
    ];

    protected $casts = [
        'percentage' => 'float',
        'order' => 'integer',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
