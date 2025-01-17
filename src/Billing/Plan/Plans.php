<?php

namespace Hyvor\Internal\Billing\Plan;

class Plans
{

    /**
     * @param class-string<\BackedEnum&PlanInterface> $class
     * @return array<value-of<self>, float>
     */
    public static function getAllPrices(string $class): array
    {
        $prices = [];

        foreach ($class::cases() as $case) {
            $prices[$case->value] = $case->getMonthlyPrice();
        }

        return $prices;

    }

}