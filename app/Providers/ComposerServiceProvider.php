<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\View\Composers\CommonComposer;
use App\View\Composers\ProfileComposer;


class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['admin.layouts.master'],
            CommonComposer::class);
        view()->composer([
            'client.layouts.master',
        ],
            ProfileComposer::class);
    }
}
