<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'payload',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];
}
