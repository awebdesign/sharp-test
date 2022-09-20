<?php

namespace App\Providers;

use Code16\Sharp\SharpServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(SharpServiceProvider::class);
//        $this->app->bind(SharpUploadModel::class, Media::class);
    }

    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
