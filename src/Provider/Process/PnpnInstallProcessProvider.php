<?php

declare(strict_types=1);

namespace WelshTidyMouse\WebAssetForgeBundle\Provider\Process;

use Symfony\Component\Process\Process;
use WelshTidyMouse\WebAssetForgeBundle\Provider\BinaryPathProviderInterface;

final readonly class PnpnInstallProcessProvider
{
    public function __construct(private BinaryPathProviderInterface $binaryProvider)
    {
    }

    public function provide(string $cwd = null): Process
    {
        $path = $this->binaryProvider->getBinaryPath('pnpm');

        return new Process([$path, 'install'], $cwd);
    }
}
