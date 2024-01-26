<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->profile()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->discoverResources(in: app_path('../app-modules/catalog/src/Filament/Resources'), for: 'Modules\\Catalog\\Filament\\Resources')
            ->discoverPages(in: app_path('../app-modules/catalog/src/Filament/Pages'), for: 'Modules\\Catalog\\Filament\\Pages')
            ->discoverWidgets(in: app_path('../app-modules/catalog/src/Filament/Widgets'), for: 'Modules\\Catalog\\Filament\\Widgets')
            ->discoverResources(in: app_path('../app-modules/order/src/Filament/Resources'), for: 'Modules\\Order\\Filament\\Resources')
            ->discoverPages(in: app_path('../app-modules/order/src/Filament/Pages'), for: 'Modules\\Order\\Filament\\Pages')
            ->discoverWidgets(in: app_path('../app-modules/order/src/Filament/Widgets'), for: 'Modules\\Order\\Filament\\Widgets')
            ->discoverResources(in: app_path('../app-modules/user/src/Filament/Resources'), for: 'Modules\\User\\Filament\\Resources')
            ->discoverPages(in: app_path('../app-modules/user/src/Filament/Pages'), for: 'Modules\\User\\Filament\\Pages')
            ->discoverWidgets(in: app_path('../app-modules/user/src/Filament/Widgets'), for: 'Modules\\User\\Filament\\Widgets')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->globalSearchKeyBindings(['command+k', 'ctrl+k']);;
    }
}
