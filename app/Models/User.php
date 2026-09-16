<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Login activities.
     */
    public function loginActivities(): HasMany
    {
        return $this->hasMany(LoginActivity::class);
    }

    /**
     * Get avatar image URL if exists.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }

        return null;
    }

    /**
     * Generate uppercase initials for user fallback avatar.
     */
    public function getInitialsAttribute(): string
    {
        $words = preg_split('/\s+/', trim($this->name ?? ''));
        $initials = '';

        if (!empty($words)) {
            if (count($words) >= 2) {
                $initials = mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1);
            } elseif (count($words) === 1 && !empty($words[0])) {
                $initials = mb_substr($words[0], 0, min(2, mb_strlen($words[0])));
            }
        }

        return strtoupper($initials ?: 'U');
    }

    /**
     * Generate consistent background color for initials avatar.
     */
    public function getAvatarBgColorAttribute(): string
    {
        $colors = [
            '#0d6efd', // Primary
            '#6610f2', // Indigo
            '#6f42c1', // Purple
            '#d63384', // Pink
            '#dc3545', // Danger
            '#fd7e14', // Orange
            '#198754', // Success
            '#20c997', // Teal
            '#0dcaf0', // Info
        ];

        $hash = crc32($this->email ?: ($this->name ?: 'user'));
        return $colors[abs($hash) % count($colors)];
    }
}
