<?php

declare(strict_types=1);

namespace WelshTidyMouse\WebAssetForgeBundle\Model;

interface ScopeInterface
{
    public function getName(): string;

    public function getPath(): string;

    public function getRunner(): string;

    /**
     * @return string[]
     */
    public function getPlugins(): array;
}
