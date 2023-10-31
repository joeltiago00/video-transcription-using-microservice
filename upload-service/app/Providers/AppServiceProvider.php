<?php

namespace App\Providers;

use Upload\Messaging\MessagingFakerResolver;
use Upload\Messaging\MessagingResolver;
use Upload\Messaging\Messaging;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(Messaging::FACADE_ACCESSOR, fn() => MessagingResolver::resolve());

        $this->bindingInterfaces();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function bindingInterfaces(): void
    {
        foreach (config('interfaces') as $abstract => $concrete) {
            $this->app->bind($abstract, fn() => app($concrete));
        }
    }
}
