<?php

declare(strict_types=1);

namespace App\Actions\Session;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateUser
{
    public static function run(array $data): void
    {
        if (!$data['password']) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        Auth::logoutOtherDevices(Arr::pull($data, 'current_password'));
        User::query()
            ->update($data);
        session()->regenerate();
    }
}