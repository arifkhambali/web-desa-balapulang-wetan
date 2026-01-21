<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Http\RedirectResponse;

class LogoutResponse implements LogoutResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        // Clear any cached data and ensure clean redirect
        $request->session()->flash('status', 'Anda telah berhasil logout.');
        
        return redirect()->to('/')->with('logout', true);
    }
}
