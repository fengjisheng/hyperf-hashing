<?php

declare(strict_types=1);

namespace Hyperf\Hashing;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Hashing\Contract\DriverInterface;
use Hyperf\Hashing\Contract\HashInterface;
use InvalidArgumentException;

class HashManager implements HashInterface
{
    /**
     * The config instance.
     */
    protected ConfigInterface $config;

    /**
     * The array of created "drivers".
     *
     * @var DriverInterface[]
     */
    protected array $drivers = [];

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Get information about the given hashed value.
     */
    public function info(string $hashedValue): array
    {
        return $this->getDriver()->info($hashedValue);
    }

    /**
     * Hash the given value.
     */
    public function make(string $value, array $options = []): string
    {
        return $this->getDriver()->make($value, $options);
    }

    /**
     * Check the given plain value against a hash.
     */
    public function check(string $value, string $hashedValue, array $options = []): bool
    {
        return $this->getDriver()->check($value, $hashedValue, $options);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     */
    public function needsRehash(string $hashedValue, array $options = []): bool
    {
        return $this->getDriver()->needsRehash($hashedValue, $options);
    }

    /**
     * Get a driver instance.
     *
     * @throws InvalidArgumentException
     */
    public function getDriver(?string $name = null): DriverInterface
    {
        if (isset($this->drivers[$name]) && $this->drivers[$name] instanceof DriverInterface) {
            return $this->drivers[$name];
        }

        $name = $name ?: $this->config->get('hashing.default', 'bcrypt');

        $config = $this->config->get("hashing.drivers.{$name}");
        if (empty($config) or empty($config['driver'])) {
            throw new InvalidArgumentException(sprintf('The hashing driver config %s is invalid.', $name));
        }

        $driverClass = $config['driver'];

        $driver = new $driverClass($config['options']);

        return $this->drivers[$name] = $driver;
    }
}
