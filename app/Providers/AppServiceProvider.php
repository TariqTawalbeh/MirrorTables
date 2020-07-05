<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Todo;
use App\Observers\TodoObserver;
use App\TodoMirror;
use App\Observers\TodoMirrorObserver;

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
        Todo::observe(TodoObserver::class);
        TodoMirror::observe(TodoMirrorObserver::class);
    }
}
