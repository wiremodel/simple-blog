<?php

namespace App;

use Filament\Auth\Http\Responses\LoginResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportRedirects\Redirector;

class CustomLoginResponse extends LoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $components = $request->input('components', []);
        $password = $components[0]['updates']['data.password'] ?? null;

        Auth::logoutOtherDevices($password);

        return parent::toResponse($request);
    }
}
