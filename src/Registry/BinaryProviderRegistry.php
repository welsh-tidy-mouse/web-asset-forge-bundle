<?php

declare(strict_types=1);

namespace WelshTidyMouse\WebAssetForgeBundle\Registry;

use Psr\Container\ContainerInterface;
use WelshTidyMouse\BinaryFetcher\Contract\BinaryProviderInterface;

final class BinaryProviderRegistry implements BinaryProviderRegistryInterface
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function get(string $key): BinaryProviderInterface
    {
        return $this->container->get($key);
    }

    public function has(string $key): bool
    {
        return $this->container->has($key);
    }
}
