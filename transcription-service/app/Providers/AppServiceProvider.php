<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Transcription\AWS\Transcriber\Transcriber;
use Transcription\AWS\Transcriber\TranscriberFactory;
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
        app()->singleton(Transcriber::class, fn() => TranscriberFactory::create());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
