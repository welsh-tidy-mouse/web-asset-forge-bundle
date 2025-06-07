<?php

declare(strict_types=1);

namespace WelshTidyMouse\WebAssetForgeBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

final class BinaryFetcherNotifyEvent extends Event
{
    public function __construct(
        private readonly string $type,
        private readonly array $params,
    ) {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
