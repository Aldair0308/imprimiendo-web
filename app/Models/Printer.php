<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Printer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ip',
        'model',
        'status',
        'is_available',
        'queue_length',
        'color_support',
        'duplex_support',
        'priority',
        'last_checked',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'color_support' => 'boolean',
        'duplex_support' => 'boolean',
        'last_checked' => 'datetime',
    ];

    public function jobs(): HasMany
    {
        return $this->hasMany(PrintJob::class);
    }
}

