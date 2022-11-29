<?php

declare(strict_types=1);

namespace App\Actions\Session;

use Illuminate\Support\Facades\Auth;

class LogoutUser
{
    public static function run(): void
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }
}