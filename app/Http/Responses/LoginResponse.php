<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $user = auth()->user();

        if ($user->role === 'superadmin') {
            return redirect()->to('/staf/admin/pusat');
        }

        if ($user->role === 'staf' && is_null($user->tenant_id)) {
            return redirect()->to('/staf/pusat');
        }

        if ($user->role === 'admin' && $user->tenant) {
            return redirect()->to('/staf/admin/' . $user->tenant->slug);
        }

        if ($user->role === 'dai' && $user->tenant) {
            return redirect()->to('/staf/dai/' . $user->tenant->slug);
        }

        if ($user->role === 'staf' && $user->tenant) {
            return redirect()->to('/staf/' . $user->tenant->slug);
        }

        return redirect()->to('/staf/login');
    }
}