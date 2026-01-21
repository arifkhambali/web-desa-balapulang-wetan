<?php

namespace App\Filament\Warga\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WelcomeWidget extends Widget
{
    protected static string $view = 'filament.warga.widgets.welcome-widget';
    
    protected static ?int $sort = -1; // Tampilkan di paling atas
    
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $user = Auth::user();
        
        return [
            'userName' => $user->name,
            'userEmail' => $user->email,
        ];
    }
}
