<?php

namespace Hyvor\Internal\Util\Transfer;

/**
 * Serialize an internal library object to transfer via HTTP
 */
trait Serializable
{

    public function serialize() : string
    {
        return serialize($this);
    }

    public static function unserialize(string $token) : static
    {
        $object = unserialize($token);

        if (!is_object($object)) {
            throw new \InvalidArgumentException('Unable to unserialize token');
        }

        $className = get_class($object);
        $classNameCurrent = get_called_class();

        if ($className !== $classNameCurrent) {
            throw new \InvalidArgumentException('Invalid token: ' . $className . ' !== ' . $classNameCurrent);
        }

        return $object;
    }

}
