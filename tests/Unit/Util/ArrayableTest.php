<?php

namespace Hyvor\Internal\Tests\Unit\Util;

use Hyvor\Internal\Util\Array\Arrayable;
use PHPUnit\Framework\TestCase;

enum UserType: string
{
    case ADMIN = 'admin';
    case USER = 'user';
}

class Name
{
    use Arrayable;

    public int $id;
    public string $name;
    public UserType $type;

}

class ArrayableTest extends TestCase
{

    public function testFromArray(): void
    {
        $name = Name::fromArray([
            'id' => 1,
            'name' => 'John Doe',
            'type' => 'admin'
        ]);

        $this->assertEquals(1, $name->id);
        $this->assertEquals('John Doe', $name->name);
        $this->assertEquals(UserType::ADMIN, $name->type);
    }

    public function testFromArrayThrowsError(): void
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessage('Missing data for type');

        $name = Name::fromArray([
            'id' => 1,
            'name' => 'John Doe'
        ]);
    }

}
