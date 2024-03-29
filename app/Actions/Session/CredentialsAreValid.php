<?php

declare(strict_types=1);

namespace App\Actions\Session;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class CredentialsAreValid
{
    public static function run(array $data): bool
    {
        $remember = Arr::pull($data, 'remember');
        if (! Auth::attempt($data, $remember)) {
            return false;
        }
        Auth::logoutOtherDevices($data['password']);
        session()->regenerate();
        return true;
    }
}