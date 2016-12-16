<?php

namespace Symbio\ApcBundle\Validator\Mapping\Cache;

use Symfony\Component\Validator\Mapping\Cache\CacheInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class ApcuCache implements CacheInterface
{
    private $prefix;

    public function __construct($prefix)
    {
        if (!extension_loaded('apcu')) {
            throw new \RuntimeException('Unable to use ApcuCache to cache validator mappings as APCu is not enabled.');
        }

        $this->prefix = $prefix;
    }

    public function has($class)
    {
        if (!function_exists('apcu_exists')) {
            $exists = false;

            apcu_fetch($this->prefix.$class, $exists);

            return $exists;
        }

        return apcu_exists($this->prefix.$class);
    }

    public function read($class)
    {
        return apcu_fetch($this->prefix.$class);
    }

    public function write(ClassMetadata $metadata)
    {
        apcu_store($this->prefix.$metadata->getClassName(), $metadata);
    }
}
