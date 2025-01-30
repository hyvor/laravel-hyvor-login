<?php

namespace Hyvor\Internal\Util\Transfer;

/**
 * Serialize an internal library object to transfer via HTTP
 * Use this for objects in used in the internal API, never in public facing APIs
 * DO NOT use for public facing objects!!!
 * @see https://www.php.net/manual/en/function.unserialize.php
 */
trait Serializable
{

    public function serialize(): string
    {
        $class = get_class($this);
        assert(str_starts_with($class, 'Hyvor\\Internal\\'), 'Invalid token: expected internal class');

        return serialize($this);
    }

    public static function unserialize(string $token): static
    {
        $object = unserialize($token);

        assert(is_object($object), 'Invalid token: expected object');
        assert($object instanceof static, 'Invalid token: expected static');

        return $object;
    }

}
