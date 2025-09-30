<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Role extends Model
{
 protected $fillable = [
 'name', 'display_name', 'description', 'is_active'
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
}