<?php

namespace App\Filament\Warga\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Notifications extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-bell';

    protected static string $view = 'filament.warga.pages.notifications';
    
    protected static ?string $navigationLabel = 'Notifikasi';
    
    protected static ?string $title = 'Notifikasi Saya';
    
    protected static ?int $navigationSort = 99;

    protected static ?string $pollingInterval = '30s'; // Auto-refresh setiap 30 detik

    public function markAsRead(string $notificationId): void
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        
        if ($notification) {
            $notification->markAsRead();
            
            $this->dispatch('notification-marked-as-read');
        }
    }

    public function markAllAsRead(): void
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        $this->dispatch('all-notifications-marked-as-read');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Auth::user()->unreadNotifications()->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return Auth::user()->unreadNotifications()->count() > 0 ? 'success' : null;
    }
}
