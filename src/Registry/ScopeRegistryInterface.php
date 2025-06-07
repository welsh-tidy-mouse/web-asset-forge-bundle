<?php

declare(strict_types=1);

namespace WelshTidyMouse\WebAssetForgeBundle\Registry;

use Traversable;
use WelshTidyMouse\WebAssetForgeBundle\Model\ScopeInterface;

interface ScopeRegistryInterface
{
    public function add(ScopeInterface $scope): void;

    public function has(string $scopeName): bool;

    public function get(string $scopeName): ScopeInterface;

    /**
     * @return Traversable<ScopeInterface>
     */
    public function getIterator(): Traversable;

    public function remove(string $packageName): void;
}
