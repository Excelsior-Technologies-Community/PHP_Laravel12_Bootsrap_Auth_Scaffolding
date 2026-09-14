<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginActivity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'login_at',
    ];

    /**
     * Get the user associated with this login activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Cast attributes.
     */
    protected function casts(): array
    {
        return [
            'login_at' => 'datetime',
        ];
    }
}