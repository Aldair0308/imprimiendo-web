<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QRSession extends Model
{
    use HasFactory;

    protected $table = 'qr_sessions';

    protected $fillable = [
        'token',
        'expires_at',
        'refreshed_at',
        'user_id',
        'active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'refreshed_at' => 'datetime',
        'active' => 'boolean',
    ];

    public function jobs(): HasMany
    {
        return $this->hasMany(PrintJob::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

