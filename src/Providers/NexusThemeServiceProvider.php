<?php

namespace Vfixtechnology\NexusTheme\Providers;

use Illuminate\Support\ServiceProvider;

class NexusThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../Resources/Views' => resource_path('themes/nexus-theme/views'),
        ]);

    }
}
