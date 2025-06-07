<?php

declare(strict_types=1);

namespace WelshTidyMouse\WebAssetForgeBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class WelshTidyMouseWebAssetForgeBundle extends AbstractBundle
{
    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->import('../config/definition.php');
    }

    /**
     * @param array<string, mixed> $config
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.php');

        $builder
            ->getDefinition('web_asset_forge.binary_fetcher')
            ->setArgument(0, $config['binaries']['download_dir'])
        ;

        $builder
            ->getDefinition('web_asset.binary_path.provider')
            ->setArgument(0, $config['binaries']['bin_dir'])
            ->setArgument(1, $config['binaries']['download_dir'])
        ;

        $builder
            ->getDefinition('web_asset_forge.scope.registry')
            ->setArgument(0, $config['scopes'])
        ;
    }
}
