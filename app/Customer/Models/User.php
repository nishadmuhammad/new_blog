<?php

namespace App\Customer\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use UsesTenantConnection;


    protected $with = ['posts'];

   
    public function posts()
    {
        return $this->hasMany(\App\Customer\Models\Post::class);
    }

}
