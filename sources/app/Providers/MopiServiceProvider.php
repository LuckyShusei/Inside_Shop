<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MopiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'mopi',
            'App\Services\Mopi'
        );
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
