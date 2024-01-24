<?php

namespace Modules\Catalog\Providers;

use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(AdminPanelProvider::class);
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'catalog');
    }

    public function boot(): void
    {
    }
}
