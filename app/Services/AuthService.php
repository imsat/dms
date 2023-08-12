<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService extends Service
{
    public function authenticate($username, $password)
    {
        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            return true;
        }
        return false;
    }
}
