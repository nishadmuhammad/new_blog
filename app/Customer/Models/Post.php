<?php

namespace App\Customer\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use UsesTenantConnection;

    public function user()
    {
        return $this->belongsTo(App\Customer\Models\User::class);
    }
}
