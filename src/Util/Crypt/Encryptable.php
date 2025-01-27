<?php

namespace Hyvor\Internal\Util\Crypt;

use Illuminate\Support\Facades\Crypt;

/**
 * This class is used for encrypting objects within the Hyvor\Internal namespace.
 * It is safe since the objects are shared between components
 */
trait Encryptable
{

    public function encrypt() : string
    {
        $className = get_class($this);

        if (!str_starts_with($className, 'Hyvor\Internal\\')) {
            throw new \InvalidArgumentException('Only objects within the Hyvor\Internal namespace can be encrypted');
        }

        return Crypt::encrypt($this);
    }

    public static function decrypt(string $token) : static
    {
        $object = Crypt::decrypt($token);

        if (!is_object($object)) {
            throw new \InvalidArgumentException('Invalid token');
        }

        $className = get_class($object);
        $classNameCurrent = get_called_class();

        if ($className !== $classNameCurrent) {
            throw new \InvalidArgumentException('Invalid token: ' . $className . ' !== ' . $classNameCurrent);
        }

        return $object;
    }

}