<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD

class Permission extends Model
{
    //
}
=======
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = ['name', 'display_name', 'description'];

    // Satu permission bisa dimiliki banyak role
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }
}

>>>>>>> 8cd26f588a7adfb1b8ecd670e42282a14a5a82f2
