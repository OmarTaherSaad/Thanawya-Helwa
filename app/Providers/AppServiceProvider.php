<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
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
        //Fix migration problem
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        $root = rtrim((string) config('app.url'), '/');
        if ($root !== '' && parse_url($root, PHP_URL_HOST)) {
            URL::forceRootUrl($root);
        }

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
