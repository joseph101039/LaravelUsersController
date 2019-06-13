<?php

namespace App\Management\Api\UsersApi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    protected $table = 'users';

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'city', 'address', 'tel', 'birthday', 'gender', 'photo', 'interest', 'account', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',  'deleted_at', 'email_verified_at',     // add the date columns
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Protect the date data from external modification.
     *
     * @var array
     */

    protected $date = ['email_verified_at', 'created_at'. 'updated_at', 'deleted_at',];
}
