<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Transcription\Messaging\Messaging;
use Transcription\Messaging\MessagingResolver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(Messaging::FACADE_ACCESSOR, fn() => MessagingResolver::resolve());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
