<?php

namespace App\Providers\Filament;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Exception;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filapanel\ClassicTheme\ClassicThemePlugin;

class AdminPanelProvider extends PanelProvider
{
    /**
     * @throws Exception
     */
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            //            Auth
            ->login()
            //            ->registration()
            ->profile()
            ->databaseNotifications()
            ->colors([
                'primary' => Color::hex('#698a5f'),
                'background' => Color::hex('#F5F5F5'),
                'secondary' => Color::hex('#898ed3'),
                'secondary-hover' => Color::hex('#5558A6'),
                'success' => Color::hex('#3a9a50'),
                'warning' => Color::hex('#FFAC02'),
                'danger' => Color::hex('#CF4753'),
                'info' => Color::hex('#527bea'),
            ])
            ->spa()
            ->font('Fustat')
            // ->font('Fustat')
            //            ->brandLogo(asset('brand/imagotipoNegro.png'))
            ->darkMode(false)
            ->brandLogoHeight('3.5rem')
            ->sidebarCollapsibleOnDesktop()
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
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
            ->plugins([
                FilamentShieldPlugin::make(),
                ClassicThemePlugin::make()
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
