<?php

declare(strict_types=1);

namespace Modules\Catalog\Providers;

use Filament\Panel;

class AdminPanelProvider extends \App\Providers\Filament\AdminPanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $modulePath = '../app-modules/catalog/src/';
        $panel = parent::panel($panel);

        return $panel
            ->discoverResources(in: app_path($modulePath.'Filament/Resources'), for: 'Modules\\Catalog\\Filament\\Resources')
            ->discoverPages(in: app_path($modulePath.'Filament/Pages'), for: 'Modules\\Catalog\\Filament\\Pages')
            ->discoverWidgets(in: app_path($modulePath.'Filament/Widgets'), for: 'App\\Filament\\Widgets');
    }
}
