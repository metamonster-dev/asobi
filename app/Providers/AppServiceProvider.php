<?php

namespace App\Providers;

use App\Observers\UserAppInfoObserver;
use App\UserAppInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        UserAppInfo::observe(UserAppInfoObserver::class);
        //
        if (php_sapi_name() != 'cli' && env('APP_ENV') == 'development')
        {
            DB::listen(function ($query) {
                Log::debug($query->sql, $query->bindings, $query->time);
            });
        }
    }
}
