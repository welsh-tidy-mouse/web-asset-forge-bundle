<?php

declare(strict_types=1);

namespace WelshTidyMouse\WebAssetForgeBundle\Provider;

interface BinaryPathProviderInterface
{
    public function getBinaryPath(string $name): string;
}
