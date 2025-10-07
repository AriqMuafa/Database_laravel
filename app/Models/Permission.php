<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Permission extends Model
{
 protected $fillable = [
 'name',
 'display_name',
 'group',
 'description',
 'is_active'
 ];
 protected $casts = [
 'is_active' => 'boolean',
 ];
 // Permission belongs to many roles
 public function roles(): BelongsToMany
 {
 return $this->belongsToMany(Role::class, 'role_permission');
 }
 // Scope untuk filter berdasarkan group
 public function scopeByGroup($query, $group)
 {
 return $query->where('group', $group);
 }
 // Scope untuk permission yang aktif
 public function scopeActive($query)
 {
 return $query->where('is_active', true);
 }
}
