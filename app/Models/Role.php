<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD

class Role extends Model
{
    //
}
=======
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['name', 'display_name', 'description'];

    // Satu role bisa dimiliki banyak user
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Satu role bisa punya banyak permission
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}

>>>>>>> 8cd26f588a7adfb1b8ecd670e42282a14a5a82f2
