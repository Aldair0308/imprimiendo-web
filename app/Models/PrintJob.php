<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrintJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'qr_session_id',
        'printer_id',
        'file_path',
        'file_name',
        'file_size',
        'format',
        'pages_count',
        'options',
        'status',
        'error_message',
    ];

    protected $casts = [
        'options' => 'array',
        'file_size' => 'integer',
        'pages_count' => 'integer',
    ];

    public function printer(): BelongsTo
    {
        return $this->belongsTo(Printer::class);
    }

    public function qrSession(): BelongsTo
    {
        return $this->belongsTo(QRSession::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

