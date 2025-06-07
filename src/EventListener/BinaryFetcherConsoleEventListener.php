<?php

declare(strict_types=1);

namespace WelshTidyMouse\WebAssetForgeBundle\EventListener;

use WelshTidyMouse\BinaryFetcher\Notifier\ConsoleNotifier;
use WelshTidyMouse\WebAssetForgeBundle\Event\BinaryFetcherNotifyEvent;

final readonly class BinaryFetcherConsoleEventListener
{
    public function __construct(private ConsoleNotifier $consoleNotifier)
    {
    }

    public function __invoke(BinaryFetcherNotifyEvent $event): void
    {
        match ($event->getType()) {
            'start' => $this->consoleNotifier->start(...$event->getParams()),
            'progress' => $this->consoleNotifier->progress(...$event->getParams()),
            'end' => $this->consoleNotifier->end(...$event->getParams()),
        };
    }
}
