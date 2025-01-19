<?php

namespace Hyvor\Internal\Billing\License\Plan;

use Hyvor\Internal\Billing\License\License;

abstract class PlanAbstract
{

    /**
     * @var array<int, array<string, Plan>>
     */
    private array $versions;

    // this only helps with config() method. Do not use for anything else.
    private ?int $currentVersionForConfig = null;

    public function __construct()
    {
        $this->config();
    }

    /**
     * Configure the plans here
     */
    abstract public function config(): void;

    protected function version(int $version, callable $callback): void
    {
        $this->currentVersionForConfig = $version;
        $callback();
        $this->currentVersionForConfig = null;
    }

    protected function plan(
        string  $name,
        float   $monthlyPrice,
        License $licence,
        ?string $nameReadable = null,
    ): void
    {
        assert($this->currentVersionForConfig !== null);
        $plan = new Plan(
            $this->currentVersionForConfig,
            $name,
            $monthlyPrice,
            $licence,
            $nameReadable
        );

        $currentVersionPlans = $this->versions[$this->currentVersionForConfig] ?? [];
        $currentVersionPlans[$name] = $plan;

        $this->versions[$this->currentVersionForConfig] = $currentVersionPlans;
    }

    public function getCurrentVersion(): int
    {
        return (int) array_key_last($this->versions);
    }

    /**
     * @return array<string, Plan>
     */
    public function getCurrentPlans(): array
    {
        return $this->versions[array_key_last($this->versions)];
    }

    public function getPlan(string $name, ?int $version = null): Plan
    {
        $version ??= $this->getCurrentVersion();
        return $this->versions[$version][$name];
    }

    /**
     * Same as getPlan() but returns null if the plan is not found.
     */
    public function tryGetPlan(string $name, ?int $version = null): ?Plan
    {
        $version ??= $this->getCurrentVersion();
        return $this->versions[$version][$name] ?? null;
    }

}