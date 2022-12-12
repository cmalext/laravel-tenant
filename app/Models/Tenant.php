<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    public function users()
    {
        return $this->hasMany(User::class, 'tenant_id', 'id');
    }

    public function channels()
    {
        return $this->hasMany(Channel::class, 'tenant_id', 'id');
    }
}
