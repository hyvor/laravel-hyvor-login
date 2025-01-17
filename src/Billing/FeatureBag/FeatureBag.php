<?php

namespace Hyvor\Internal\Billing\FeatureBag;

use Illuminate\Support\Facades\Log;

abstract class FeatureBag
{

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $class = new \ReflectionClass(static::class);

        $properties = $class->getProperties();
        $instance = $class->newInstanceWithoutConstructor();

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            if (array_key_exists($propertyName, $data)) {
                $property->setValue($instance, $data[$propertyName]);
            } else {
                Log::alert("Property $propertyName is missing in the feature bag data array");
            }
        }

        return $instance;

    }

}