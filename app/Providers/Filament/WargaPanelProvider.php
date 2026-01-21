<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
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
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class WargaPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('warga')
            ->path('warga')
            ->authGuard('web') // Explicitly set auth guard
            ->registration() // Warga bisa register sendiri
            ->spa() // Enable SPA mode (wire:navigate) untuk navigasi yang lebih smooth
            ->brandName('Portal Warga')
            ->colors([
                'primary' => Color::Green, // Warna hijau biar beda sama admin
            ])
            ->discoverResources(app_path('Filament/Warga/Resources'), 'App\\Filament\\Warga\\Resources')
            ->discoverPages(app_path('Filament/Warga/Pages'), 'App\\Filament\\Warga\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(app_path('Filament/Warga/Widgets'), 'App\\Filament\\Warga\\Widgets')
            ->widgets([
                \App\Filament\Warga\Widgets\WelcomeWidget::class,
                \App\Filament\Warga\Widgets\WargaStatsOverview::class,
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
                    ->url(fn () => route('switch-language', 'id'))
                    ->icon('heroicon-o-language'),
                'en' => \Filament\Navigation\MenuItem::make()
                    ->label('English')
                    ->url(fn () => route('switch-language', 'en'))
                    ->icon('heroicon-o-language'),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->sidebarCollapsibleOnDesktop() // Sidebar bisa di-collapse
            ->databaseNotifications() // Enable database notifications
            ->databaseNotificationsPolling('30s'); // Poll notifikasi setiap 30 detik
    }
}
