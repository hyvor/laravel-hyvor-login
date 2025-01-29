<?php

namespace Hyvor\Internal\Tests\Unit\Auth;

use Hyvor\Internal\Auth\AuthUser;
use Hyvor\Internal\Auth\HasUser;
use Hyvor\Internal\Tests\TestCase;

class ModelWithHasUser
{
    use HasUser;

    public ?int $user_id = 10;
}

class HasUserTest extends TestCase
{

    public function testHasUser(): void
    {
        $model = new ModelWithHasUser();
        $user = $model->user();
        $this->assertInstanceOf(AuthUser::class, $user);
        $this->assertEquals(10, $user->id);
    }

    public function testReturnsNullIfUserIdIsNotSet(): void
    {
        $model = new ModelWithHasUser();
        $model->user_id = null;
        $this->assertNull($model->user());
    }

}
