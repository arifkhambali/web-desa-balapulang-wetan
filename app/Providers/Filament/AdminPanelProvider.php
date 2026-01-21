<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Resources;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->authGuard('web') // Explicitly set auth guard
            ->spa() // Enable SPA mode (wire:navigate) untuk navigasi yang lebih smooth
            ->brandName('Admin Panel')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(app_path('Filament/Admin/Resources'), 'App\\Filament\\Admin\\Resources')
            ->discoverPages(app_path('Filament/Admin/Pages'), 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(app_path('Filament/Admin/Widgets'), 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
                \App\Http\Middleware\SetFilamentLocale::class, // Add middleware here
            ])
            ->userMenuItems([
                'id' => \Filament\Navigation\MenuItem::make()
                    ->label('Bahasa Indonesia')
                    ->url(fn() => route('switch-language', 'id'))
                    ->icon('heroicon-o-language'),
                'en' => \Filament\Navigation\MenuItem::make()
                    ->label('English')
                    ->url(fn() => route('switch-language', 'en'))
                    ->icon('heroicon-o-language'),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(\App\Filament\Admin\Plugins\CustomBlogPlugin::make())
            ->sidebarCollapsibleOnDesktop() // Sidebar bisa di-collapse
            ->databaseNotifications() // Enable database notifications
            ->databaseNotificationsPolling('30s'); // Poll notifikasi setiap 30 detik
    }
}
