<?php

namespace Hyvor\Internal\Tests\Unit\Http\Exceptions;

use Hyvor\Internal\Http\Exceptions\HttpException;
use Hyvor\Internal\Tests\TestCase;

class HttpExceptionTest extends TestCase
{

    public function testCreatesWithData(): void
    {
        $exception = new HttpException('message', 1001, ['key' => 'value']);
        $this->assertEquals('message', $exception->getMessage());
        $this->assertEquals(1001, $exception->getCode());
        $this->assertEquals(['key' => 'value'], $exception->data);
    }

}
