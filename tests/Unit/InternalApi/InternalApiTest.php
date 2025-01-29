<?php

namespace Hyvor\Internal\Tests\Unit\InternalApi;

use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\InternalApi\Exceptions\InternalApiCallFailedException;
use Hyvor\Internal\InternalApi\InternalApi;
use Hyvor\Internal\InternalApi\InternalApiMethod;
use Hyvor\Internal\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class InternalApiTest extends TestCase
{
    public function testCallsTalkInternalApi(): void
    {
        $this->freezeTime();

        Http::fake([
            'talk.hyvor.com/api/internal/delete-user' => Http::response(['success' => true], 200)
        ]);

        InternalApi::call(
            ComponentType::TALK,
            'POST',
            'delete-user',
            ['user_id' => 123]
        );

        Http::assertSent(function ($request) {
            $this->assertEquals('https://talk.hyvor.com/api/internal/delete-user', $request->url());

            $message = $request['message'];
            $message = decrypt($message, false);
            $data = json_decode($message, true);

            $this->assertEquals(123, $data['data']['user_id']);
            $this->assertEquals(now()->timestamp, $data['timestamp']);

            $headers = $request->headers();
            $this->assertEquals('core', $headers['X-Internal-Api-From'][0]);
            $this->assertEquals('talk', $headers['X-Internal-Api-To'][0]);

            return true;
        });
    }

    public function testCallsWithGet(): void
    {
        Http::fake([
            'talk.hyvor.com/api/internal/sudo/users*' => Http::response(['success' => true], 200)
        ]);

        $response = InternalApi::call(
            ComponentType::TALK,
            InternalApiMethod::GET,
            '/sudo/users',
            ['user_id' => 123]
        );

        $this->assertEquals(['success' => true], $response);

        Http::assertSent(function ($request) {
            $this->assertStringStartsWith('https://talk.hyvor.com/api/internal/sudo/users', $request->url());
            $this->assertEquals('GET', $request->method());

            $message = $request['message'];
            $message = decrypt($message, false);
            $data = json_decode($message, true);
            $this->assertEquals(123, $data['data']['user_id']);

            return true;
        });
    }

    public function testThrowsAnErrorIfTheResponseFails(): void
    {
        Http::fake([
            'talk.hyvor.com/api/internal/delete-user' => Http::response(['success' => false], 500)
        ]);

        $this->expectException(InternalApiCallFailedException::class);
        $this->expectExceptionMessage('Internal API call to https://talk.hyvor.com/api/internal/delete-user failed. Status code: 500 - {"success":false}');

        InternalApi::call(
            ComponentType::TALK,
            'POST',
            'delete-user',
            ['user_id' => 123]
        );
    }

    public function testThrowsAnErrorOnConnectionException(): void
    {
        Http::fake([
            'talk.hyvor.com/api/internal/delete-user' => function () {
                throw new \Illuminate\Http\Client\ConnectionException('Connection error');
            }
        ]);

        $this->expectException(InternalApiCallFailedException::class);
        $this->expectExceptionMessage('Internal API call to https://talk.hyvor.com/api/internal/delete-user failed. Connection error: Connection error');

        InternalApi::call(
            ComponentType::TALK,
            'POST',
            'delete-user',
            ['user_id' => 123]
        );
    }
}
