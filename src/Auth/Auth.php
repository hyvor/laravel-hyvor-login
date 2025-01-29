<?php

namespace Hyvor\Internal\Auth;

use Hyvor\Internal\Auth\Providers\CurrentProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class Auth
{

    public static function check(): false|AuthUser
    {
        return CurrentProvider::get()->check();
    }

    public static function login(?string $redirect = null): RedirectResponse|Redirector
    {
        return CurrentProvider::get()->login($redirect);
    }

    public static function signup(?string $redirect = null): RedirectResponse|Redirector
    {
        return CurrentProvider::get()->signup($redirect);
    }

    public static function logout(?string $redirect = null): RedirectResponse|Redirector
    {
        return CurrentProvider::get()->logout($redirect);
    }

}
