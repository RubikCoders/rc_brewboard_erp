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
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
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
            ->colors([
                'primary' => Color::hex('#698a5f'),
                'background' => Color::hex('#FFFDF6'),
                'secondary' => Color::hex('#80735B'),
                'secondary-hover' => Color::hex('#E4E6C3'),
                'success' => Color::hex('#0BBA4E'),
                'warning' => Color::hex('#F7CF67'),
                'danger' => Color::hex('#d68787'),
                'info' => Color::hex('#84BFC3'),
            ])
            ->spa()
            ->darkMode(false)
            ->sidebarCollapsibleOnDesktop()
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                //                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
            ])
            ->navigationGroups([
                'Gestión de Inventario',
                'Personal'
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
            ])
            ->navigationGroups([
                \Filament\Navigation\NavigationGroup::make()
                    ->label('Personal')
                    ->icon('heroicon-o-identification')
                    ->collapsed()
                    ->collapsible(),
                \Filament\Navigation\NavigationGroup::make()
                    ->label('Filament Shield')
                    ->icon('heroicon-o-shield-check')
                    ->collapsed()
                    ->collapsible(),
            ])
            ->assets([
                Css::make('general-style', resource_path('css/general.css')),
            ]);
        ;
    }
}
