<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DashboardAccessRequest extends Model
{
    protected $fillable = [
        'email',
        'message',
        'status',
        'access_key_hash',
        'access_key_expires_at',
        'approved_by',
    ];

    protected function casts(): array
    {
        return [
            'access_key_expires_at' => 'datetime',
        ];
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
