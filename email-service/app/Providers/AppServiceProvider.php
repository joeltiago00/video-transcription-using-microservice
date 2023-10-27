<?php

namespace App\Providers;

use Email\Messaging\MessagingConfig;
use Email\Messaging\MessagingResolver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MessagingConfig::FACADE_ACCESSOR, fn() => MessagingResolver::resolve());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
