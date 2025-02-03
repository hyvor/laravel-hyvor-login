<?php

namespace Hyvor\Internal\Resource;

use Carbon\Carbon;

final class ResourceFake extends Resource
{

    /** @var array<array{userId: int, resourceId: int}> */
    private array $registered = [];

    /** @var array<int> */
    private array $deleted = [];

    public static function enable(): void
    {
        app()->singleton(Resource::class, function () {
            return new self();
        });
    }

    public static function assertRegistered(int $userId, int $resourceId): void
    {
        $resource = app(Resource::class);
        assert($resource instanceof self);

        $registered = false;

        foreach ($resource->registered as $registered) {
            if ($registered['userId'] === $userId && $registered['resourceId'] === $resourceId) {
                $registered = true;
                break;
            }
        }

        \PHPUnit\Framework\Assert::assertTrue(
            $registered,
            "Resource not registered for user $userId and resource $resourceId"
        );
    }

    public static function assertDeleted(int $resourceId): void
    {
        $resource = app(Resource::class);
        assert($resource instanceof self);

        \PHPUnit\Framework\Assert::assertContains(
            $resourceId,
            $resource->deleted,
            "Resource not deleted: $resourceId"
        );
    }

    public function register(
        int $userId,
        int $resourceId,
        ?Carbon $at = null
    ): void {
        $this->registered[] = [
            'userId' => $userId,
            'resourceId' => $resourceId,
        ];
    }

    public function delete(int $resourceId): void
    {
        $this->deleted[] = $resourceId;
    }

}
