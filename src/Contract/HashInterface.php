<?php

declare(strict_types=1);

namespace Hyperf\Hashing\Contract;

interface HashInterface extends DriverInterface
{
    /**
     * Get a driver instance.
     */
    public function getDriver(?string $name = null): DriverInterface;
}
