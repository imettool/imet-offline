<?php

namespace App\Models;

use \AndreaMarelli\ModularForms\Models\User\User as baseUser;

class User extends baseUser
{
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'organisation',
        'function',
        'country'
    ];

}
