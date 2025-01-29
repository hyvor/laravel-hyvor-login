<?php

namespace Hyvor\Internal\Tests\Feature\Auth;

use Hyvor\Internal\Auth\AuthUser;
use Hyvor\Internal\Tests\TestCase;
use Illuminate\Support\Collection;

class AuthUserTest extends TestCase
{

    public function testIsCreatedFromArray(): void
    {
        $user = AuthUser::fromArray([
            'id' => 1,
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@hyvor.com',
            'picture_url' => 'https://hyvor.com/john.jpg',
        ]);

        $this->assertEquals(1, $user->id);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('johndoe', $user->username);
        $this->assertEquals('john@hyvor.com', $user->email);
        $this->assertEquals('https://hyvor.com/john.jpg', $user->picture_url);
        $this->assertNull($user->location);
        $this->assertNull($user->bio);
        $this->assertNull($user->website_url);
        $this->assertNull($user->email_relay);

    }

    public function testFromIds(): void
    {
        $users = AuthUser::fromIds([1, 2]);

        $this->assertInstanceOf(Collection::class, $users);
        $this->assertCount(2, $users);
        $this->assertInstanceOf(AuthUser::class, $users->first());
        $this->assertEquals(1, $users->first()->id);
        $this->assertEquals(2, $users->last()?->id);

        $user = AuthUser::fromId(3);

        $this->assertInstanceOf(AuthUser::class, $user);
        $this->assertEquals(3, $user->id);

    }


    public function testFromUsernames(): void
    {
        $users = AuthUser::fromUsernames(['johndoe', 'janedoe']);

        $this->assertInstanceOf(Collection::class, $users);
        $this->assertCount(2, $users);
        $this->assertInstanceOf(AuthUser::class, $users->first());
        $this->assertEquals('johndoe', $users->first()->username);
        $this->assertEquals('janedoe', $users->last()?->username);

        $user = AuthUser::fromUsername('jimdoe');

        $this->assertInstanceOf(AuthUser::class, $user);
        $this->assertEquals('jimdoe', $user->username);

    }

    public function testFromEmails(): void
    {
        $users = AuthUser::fromEmails(['johndoe@hyvor.com', 'janedoe@hyvor.com']);

        $this->assertInstanceOf(Collection::class, $users);
        $this->assertCount(2, $users);
        $this->assertInstanceOf(AuthUser::class, $users->first());

        $this->assertEquals('johndoe@hyvor.com', $users->first()->email);
        $this->assertEquals('janedoe@hyvor.com', $users->last()?->email);

        $user = AuthUser::fromEmail('jimdoe@hyvor.com');

        $this->assertInstanceOf(AuthUser::class, $user);
        $this->assertEquals('jimdoe@hyvor.com', $user->email);

    }

}
