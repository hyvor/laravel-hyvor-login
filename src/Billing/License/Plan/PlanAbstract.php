<?php

namespace Hyvor\Internal\Billing\License\Plan;

use Hyvor\Internal\Billing\License\License;

abstract class PlanAbstract
{

    /**
     * @var array<int, Plan[]>
     */
    public array $versions;

    public ?int $currentVersion = null;

    /**
     * Configure the plans here
     */
    abstract public function config(): void;

    public function version(int $version, callable $callback): void
    {
        $this->currentVersion = $version;
        $callback();
        $this->currentVersion = null;
    }

    public function plan(
        string  $name,
        float   $monthlyPrice,
        License $licence,
        ?string $nameReadable = null,
    ): void
    {
        assert($this->currentVersion !== null);
        $this->versions[$this->currentVersion][] = new Plan($name, $monthlyPrice, $licence, $nameReadable);
    }

}