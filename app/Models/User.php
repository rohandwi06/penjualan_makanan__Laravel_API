<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use \App\Models\Role;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;


    protected $fillable = [
        'nama',
        'username',
        'password',
        'role_id',
    ];


    protected $hidden = [
        'password',
    ];

    public function role() {

        return $this->belongsTo(Role::class, 'role_id');

    }


}
