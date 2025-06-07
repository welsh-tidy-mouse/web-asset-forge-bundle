<?php

declare(strict_types=1);

namespace WelshTidyMouse\WebAssetForgeBundle\Model;

final readonly class Scope implements ScopeInterface
{
    /**
     * @param string[] $plugins
     */
    public function __construct(
        private string $name,
        private string $path,
        private string $runner,
        private array $plugins = [],
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getRunner(): string
    {
        return $this->runner;
    }

    /**
     * @inheritdoc
     */
    public function getPlugins(): array
    {
        return $this->plugins;
    }
}
