<?php

namespace Hyvor\Internal\Tests\Feature\Auth;

use Hyvor\Internal\Auth\Auth;
use Hyvor\Internal\Auth\Providers\Fake\AuthFake;
use Hyvor\Internal\Tests\TestCase;
use Illuminate\Http\RedirectResponse;

class AuthTest extends TestCase
{

    public function testChecks(): void
    {
        AuthFake::enable(['id' => 1]);
        $user = Auth::check();
        $this->assertNotFalse($user);
        $this->assertEquals(1, $user->id);

        AuthFake::enable(['id' => 2]);
        $user = Auth::check();
        $this->assertNotFalse($user);
        $this->assertEquals(2, $user->id);

        AuthFake::enable(null);
        $this->assertFalse(Auth::check());
    }

    public function testRedirects(): void
    {
        config(['internal.auth.provider' => 'hyvor']);

        $login = Auth::login();
        $this->assertInstanceOf(RedirectResponse::class, $login);
        $this->assertStringStartsWith('https://hyvor.com/login?redirect=', $login->getTargetUrl());

        $signup = Auth::signup();
        $this->assertInstanceOf(RedirectResponse::class, $signup);
        $this->assertStringStartsWith('https://hyvor.com/signup?redirect=', $signup->getTargetUrl());

        $logout = Auth::logout();
        $this->assertInstanceOf(RedirectResponse::class, $logout);
        $this->assertStringStartsWith('https://hyvor.com/logout?redirect=', $logout->getTargetUrl());
    }

}
