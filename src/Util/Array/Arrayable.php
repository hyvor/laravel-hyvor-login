<?php

namespace Hyvor\Internal\Util\Array;

trait Arrayable
{

    /**
     * @param array<mixed> $array
     * @return static
     */
    public static function fromArray(array $array) : static
    {
        $object = new static();

        $reflection = new \ReflectionClass($object);
        foreach ($reflection->getProperties() as $property) {
            $name = $property->getName();
            if (array_key_exists($name, $array)) {

                $value = $array[$name];

                // check if the property is an enum
                $type = $property->getType();
                if ($type && $type->isBuiltin() === false) {
                    $enum = $type->getName();
                    if (enum_exists($enum)) {
                        $value = $enum::from($value);
                    }
                }

                $property->setValue($object, $value);

            } else {
                throw new \Error('Missing data for ' . $name);
            }
        }

        return $object;
    }

}