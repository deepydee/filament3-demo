<?php

declare(strict_types=1);

namespace Modules\Order\Providers;

use Filament\Panel;

class AdminPanelProvider extends \App\Providers\Filament\AdminPanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $modulePath = '../app-modules/catalog/src/';
        $panel = parent::panel($panel);

        return $panel
            ->discoverResources(in: app_path($modulePath.'Filament/Resources'), for: 'Modules\\Order\\Filament\\Resources')
            ->discoverPages(in: app_path($modulePath.'Filament/Pages'), for: 'Modules\\Order\\Filament\\Pages')
            ->discoverWidgets(in: app_path($modulePath.'Filament/Widgets'), for: 'Modules\\Order\\Filament\\Widgets');
    }
}
