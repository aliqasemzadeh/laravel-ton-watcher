<?php

namespace AliQasemzadeh\LaravelTonWatcher;

use Illuminate\Support\ServiceProvider;

class TonWatcherServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/ton-watcher.php' => config_path('ton-watcher.php'),
        ]);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/ton-watcher.php', 'ton-watcher'
        );
    }

}
