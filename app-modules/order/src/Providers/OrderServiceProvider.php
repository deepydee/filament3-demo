<?php

namespace Modules\Order\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Order\Providers\AdminPanelProvider;

class OrderServiceProvider extends ServiceProvider
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
