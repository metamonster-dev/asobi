<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Helper;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('helper', function ($app) {
            return new Helper();
        });


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
