<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'role',
    ];

    /**
     * Check if user is Admin Utama (Superadmin).
     */
    public function isAdminUtama(): bool
    {
        return $this->role === 'admin_utama' 
            || strtolower(trim((string)$this->email)) === 'rsbaladhikahusada@gmail.com';
    }

    /**
     * Determine if the user can manage (update/delete) the given book.
     */
    public function canManageBook(?Book $book): bool
    {
        if (!$book) {
            return false;
        }
        if ($this->isAdminUtama()) {
            return true;
        }
        return $book->user_id !== null && $book->user_id === $this->id;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
