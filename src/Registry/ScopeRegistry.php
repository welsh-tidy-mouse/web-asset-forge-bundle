<?php

declare(strict_types=1);

namespace WelshTidyMouse\WebAssetForgeBundle\Registry;

use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;
use WelshTidyMouse\WebAssetForgeBundle\Model\Scope;
use WelshTidyMouse\WebAssetForgeBundle\Model\ScopeInterface;

/**
 * @implements \IteratorAggregate<string, ScopeInterface>
 */
class ScopeRegistry implements IteratorAggregate, ScopeRegistryInterface
{
    /**
     * @var array<string, ScopeInterface>
     */
    private array $scopes = [];

    /**
     * @param array<string, array{path: string, runner: string, plugins: string[]}> $scopes
     */
    public function __construct(array $scopes = [])
    {
        foreach ($scopes as $name => $scope) {
            $this->add(new Scope($name, $scope['path'], $scope['runner'], $scope['plugins']));
        }
    }

    public function add(ScopeInterface $scope): void
    {
        $this->scopes[$scope->getName()] = $scope;
    }

    public function has(string $scopeName): bool
    {
        return isset($this->scopes[$scopeName]);
    }

    public function get(string $scopeName): ScopeInterface
    {
        if (!$this->has($scopeName)) {
            throw new InvalidArgumentException(\sprintf('The scope "%s" does not exist.', $scopeName));
        }

        return $this->scopes[$scopeName];
    }

    /**
     * @return Traversable<ScopeInterface>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator(array_values($this->scopes));
    }

    public function remove(string $packageName): void
    {
        unset($this->scopes[$packageName]);
    }
}
