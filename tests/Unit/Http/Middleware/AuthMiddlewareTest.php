<?php

namespace Hyvor\Helper\Tests\Unit\Http\Middleware;

use Hyvor\Helper\Http\Exceptions\HttpException;
use Hyvor\Helper\Http\Middleware\AccessAuthUser;
use Hyvor\Helper\Http\Middleware\AuthMiddleware;
use Illuminate\Http\Request;

it('throws an error when the user is not logged in', function () {

    config(['hyvor-helper.auth.fake.user_id' => null]);
    $request = new Request();
    (new AuthMiddleware())->handle($request, function () {});

})->throws(HttpException::class, 'Unauthorized');

it('sets access auth user when user is logged in', function() {

    config(['hyvor-helper.auth.fake.user_id' => 15]);

    $request = new Request();
    (new AuthMiddleware())->handle($request, function () {
        $user = app(AccessAuthUser::class);
        expect($user->id)->toBe(15);
    });

});