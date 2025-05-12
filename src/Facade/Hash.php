<?php

declare(strict_types=1);

namespace Hyperf\Hashing\Facade;

use Hyperf\Hashing\Contract\DriverInterface;
use Hyperf\Hashing\HashManager;

/**
 * @method static array info(string $hashedValue)
 * @method static string make(string $value, array $options = [])
 * @method static bool check(string $value, string $hashedValue, array $options = [])
 * @method static string needsRehash(string $hashedValue, array $options = [])
 */
class Hash
{
    public static function __callStatic($method, $arguments)
    {
        return static::getDriver()->{$method}(...$arguments);
    }

    public static function getDriver(?string $name = null): DriverInterface
    {
        return \Hyperf\Support\make(HashManager::class)->getDriver($name);
    }
}
