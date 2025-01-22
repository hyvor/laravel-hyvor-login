<?php

namespace Hyvor\Internal\Billing\License;

use Hyvor\Internal\Util\Transfer\Serializable;
use Illuminate\Support\Facades\Log;

/**
 * Add license parameters in the constructor.
 * When creating a license, set the limits to that of the trial license.
 * ONLY USE int and bool types in the constructor.
 */
abstract class License
{

    use Serializable;

    public DerivedFrom $derivedFrom;

    public function setDerivedFrom(DerivedFrom $derivedFrom): static
    {
        $this->derivedFrom = $derivedFrom;
        return $this;
    }

    /**
     * @deprecated
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
