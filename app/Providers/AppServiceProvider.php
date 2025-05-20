<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // ###### Custom validation Rules ######
        Validator::extend('custom_text', function($attribute, $value){
            return preg_match('/^[0-9\pL\s\'\+\-\_\/\(\)]+$/u', $value);
        });
    }
}
