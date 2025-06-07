<?php

declare(strict_types=1);

namespace WelshTidyMouse\WebAssetForgeBundle\Registry;

use WelshTidyMouse\BinaryFetcher\Contract\BinaryProviderInterface;

interface BinaryProviderRegistryInterface
{
    public function get(string $key): BinaryProviderInterface;

    public function has(string $key): bool;
}
