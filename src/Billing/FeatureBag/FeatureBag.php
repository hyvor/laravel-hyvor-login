<?php

namespace Hyvor\Internal\Billing\FeatureBag;

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
                throw new \InvalidArgumentException("Property $propertyName is missing in the data array");
            }
        }

        return $instance;

    }

}