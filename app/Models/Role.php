<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Role extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'is_active'
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }
    public function givePermission(Permission $permission)
    {
        return $this->permissions()->attach($permission);
    }
    public function removePermission(Permission $permission)
    {
        return $this->permissions()->detach($permission);
    }
    public function getStatusBadgeAttribute()
    {
        $badges = [
            true => '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Active</span>',
            false => '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Inactive</span>'
        ];
        return $badges[(bool)$this->is_active];
    }
}