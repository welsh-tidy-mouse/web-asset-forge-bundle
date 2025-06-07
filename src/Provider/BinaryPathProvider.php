<?php

declare(strict_types=1);

namespace WelshTidyMouse\WebAssetForgeBundle\Provider;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use WelshTidyMouse\BinaryFetcher\BinaryFetcherInterface;
use WelshTidyMouse\WebAssetForgeBundle\Registry\BinaryProviderRegistryInterface;

final readonly class BinaryPathProvider implements BinaryPathProviderInterface
{
    public function __construct(
        private string $binaryPath,
        private string $binaryDownloadPath,
        private Filesystem $filesystem,
        private BinaryProviderRegistryInterface $binaryProviderRegistry,
        private BinaryFetcherInterface $binaryFetcher,
    ) {
    }

    public function getBinaryPath(string $name): string
    {
        $binaryPath = Path::join($this->binaryPath, $name);
        if ($this->filesystem->exists($binaryPath)) {
            return $binaryPath;
        }

        if (!$this->filesystem->exists($this->binaryDownloadPath)) {
            $this->filesystem->mkdir($this->binaryDownloadPath);
        }

        if (!$this->filesystem->exists($this->binaryPath)) {
            $this->filesystem->mkdir($this->binaryPath);
        }

        $provider = $this->binaryProviderRegistry->get($name);
        $binaryName = $this->binaryFetcher->download($provider);

        $this->filesystem->copy(Path::join($this->binaryDownloadPath, $binaryName), $binaryPath);
        $this->filesystem->chmod($binaryPath, 0777);

        return $binaryPath;
    }
}
