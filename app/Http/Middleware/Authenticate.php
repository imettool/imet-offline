<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate extends Middleware
{

    /**
     * Create a new middleware instance.
     */
    public function __construct(Auth $auth)
    {
        // Force Authentication of user 0
        if(!\Illuminate\Support\Facades\Auth::check()){
            \Illuminate\Support\Facades\Auth::loginUsingId(0, true);
        }

        parent::__construct($auth);
    }

}
