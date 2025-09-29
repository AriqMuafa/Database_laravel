<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
=======
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_id',
        'orang_id', // relasi ke tabel orang
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi: User belongs to one Role
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relasi: User belongs to Orang (data identitas)
     */
    public function orang(): BelongsTo
    {
        return $this->belongsTo(Orang::class, 'orang_id');
    }

    /**
     * Cek apakah user punya permission tertentu
     */
    public function hasPermission(string $permission): bool
    {
        return $this->role?->permissions()->where('name', $permission)->exists() ?? false;
    }

    /**
     * Helper untuk cek role
     */
    public function isAdmin(): bool
    {
        return $this->role?->name === 'admin';
    }

    public function isPustakawan(): bool
    {
        return $this->role?->name === 'pustakawan';
    }

    public function isAnggota(): bool
    {
        return $this->role?->name === 'anggota';
    }
>>>>>>> 8cd26f588a7adfb1b8ecd670e42282a14a5a82f2
}
