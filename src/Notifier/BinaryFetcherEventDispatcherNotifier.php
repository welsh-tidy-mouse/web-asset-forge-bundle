<?php

declare(strict_types=1);

namespace WelshTidyMouse\WebAssetForgeBundle\Notifier;

use Psr\EventDispatcher\EventDispatcherInterface;
use WelshTidyMouse\BinaryFetcher\Notifier\NotifierInterface;
use WelshTidyMouse\BinaryFetcher\Type\OsType;
use WelshTidyMouse\BinaryFetcher\Type\SystemArchType;
use WelshTidyMouse\WebAssetForgeBundle\Event\BinaryFetcherNotifyEvent;

final readonly class BinaryFetcherEventDispatcherNotifier implements NotifierInterface
{
    public function __construct(private EventDispatcherInterface $dispatcher)
    {
    }

    public function start(string $name, string $version, OsType $os, SystemArchType $arch): void
    {
        $this->dispatcher->dispatch(new BinaryFetcherNotifyEvent('start', [$name, $version, $os, $arch]));
    }

    public function progress(string $assetFileName, int $dlSize, int $dlNow): void
    {
        $this->dispatcher->dispatch(new BinaryFetcherNotifyEvent('progress', [$assetFileName, $dlSize, $dlNow]));
    }

    public function end(string $binaryFileName, string $downloadDirPath): void
    {
        $this->dispatcher->dispatch(new BinaryFetcherNotifyEvent('end', [$binaryFileName, $downloadDirPath]));
    }
}
