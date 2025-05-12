<?php

declare(strict_types=1);

namespace Hyperf\Hashing;

use Hyperf\Hashing\Contract\HashInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                HashInterface::class => HashManager::class,
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The configuration file of hashing.',
                    'source' => __DIR__ . '/../publish/hashing.php',
                    'destination' => BASE_PATH . '/config/autoload/hashing.php',
                ],
            ],
        ];
    }
}
