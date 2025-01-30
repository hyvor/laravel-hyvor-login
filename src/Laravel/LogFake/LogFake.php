<?php

namespace Hyvor\Internal\Laravel\LogFake;

use Illuminate\Support\Facades\Log;
use TiMacDonald\Log\LogEntry;

class LogFake
{

    /**
     * Run this function to fake the log.
     */
    public static function fake(): void
    {
        if (!app()->environment('testing')) {
            throw new \Exception('Cannot fake log in non-testing environment');
        }

        \TiMacDonald\Log\LogFake::bind();
    }

    /**
     * @param array<mixed>|null $context
     */
    public static function assertLogged(
        string $level,
        string $message = null,
        ?array $context = null,
    ): void {
        // @phpstan-ignore-next-line
        Log::assertLogged(function (LogEntry $entry) use ($level, $message, $context) {
            \PHPUnit\Framework\Assert::assertEquals($level, $entry->level);
            \PHPUnit\Framework\Assert::assertEquals($message, $entry->message);
            if ($context !== null) {
                \PHPUnit\Framework\Assert::assertEquals($context, $entry->context);
            }
            return true;
        });
    }

    /**
     * @param callable(string, string, array<mixed>): bool $callback
     */
    public static function assertLoggedCallback(
        callable $callback
    ): void {
        // @phpstan-ignore-next-line
        Log::assertLogged(function (LogEntry $entry) use ($callback) {
            return $callback($entry->level, $entry->message, $entry->context);
        });
    }

}
