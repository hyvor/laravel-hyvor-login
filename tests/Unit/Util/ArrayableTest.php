<?php

namespace Hyvor\Internal\Tests\Unit\Util;

use Hyvor\Internal\Util\Array\Arrayable;

enum UserType : string {
    case ADMIN = 'admin';
    case USER = 'user';
}

class Name {
    use Arrayable;

    public int $id;
    public string $name;
    public UserType $type;

}

it('from array', function() {

    $name = Name::fromArray([
        'id' => 1,
        'name' => 'John Doe',
        'type' => 'admin'
    ]);

    expect($name->id)->toBe(1);
    expect($name->name)->toBe('John Doe');
    expect($name->type)->toBe(UserType::ADMIN);

});

it('throws an error on missing data', function() {

    $name = Name::fromArray([
        'id' => 1,
        'name' => 'John Doe'
    ]);

})->throws(\Error::class, 'Missing data for type');