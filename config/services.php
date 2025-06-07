<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use WelshTidyMouse\BinaryFetcher\BinaryFetcher;
use WelshTidyMouse\BinaryFetcher\BinaryFetcherInterface;
use WelshTidyMouse\BinaryFetcher\Contract\BinaryProviderInterface;
use WelshTidyMouse\BinaryFetcher\Tool\PlatformDetector;
use WelshTidyMouse\BinaryFetcher\Tool\PlatformDetectorInterface;
use WelshTidyMouse\BinaryProvider\BunJsBinaryProvider;
use WelshTidyMouse\BinaryProvider\PnpmBinaryProvider;
use WelshTidyMouse\WebAssetForgeBundle\Command\AssetInstallCommand;
use WelshTidyMouse\WebAssetForgeBundle\Model\ScopeRegistryFactory;
use WelshTidyMouse\WebAssetForgeBundle\Notifier\BinaryFetcherEventDispatcherNotifier;
use WelshTidyMouse\WebAssetForgeBundle\Provider\BinaryPathProvider;
use WelshTidyMouse\WebAssetForgeBundle\Provider\BinaryPathProviderInterface;
use WelshTidyMouse\WebAssetForgeBundle\Provider\Process\BunJs\InstallProcessProvider as BunJsInstallProcessProvider;
use WelshTidyMouse\WebAssetForgeBundle\Provider\Process\PnpnInstallProcessProvider as PnpmInstallProcessProvider;
use WelshTidyMouse\WebAssetForgeBundle\Registry\BinaryProviderRegistry;
use WelshTidyMouse\WebAssetForgeBundle\Registry\BinaryProviderRegistryInterface;
use WelshTidyMouse\WebAssetForgeBundle\Registry\ScopeRegistry;
use WelshTidyMouse\WebAssetForgeBundle\Registry\ScopeRegistryInterface;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->instanceof(BinaryProviderInterface::class)
            ->tag('web_asset.binary_fetcher')

        ->alias('web_asset_forge.http_client', 'http_client')
        
        ->set('web_asset.binary_provider.bun_js', BunJsBinaryProvider::class)
        ->set('web_asset.binary_provider.pnpm', PnpmBinaryProvider::class)

        ->set('web_asset.binary_provider.registry', BinaryProviderRegistry::class)
            ->args([tagged_locator('web_asset.binary_fetcher', defaultIndexMethod: 'getName')])
            ->alias(BinaryProviderRegistryInterface::class, 'web_asset.binary_fetcher.registry')

        ->set('web_asset.binary_path.provider', BinaryPathProvider::class)
            ->args([
                    abstract_arg('directory where binary files are stored'),
                    abstract_arg('directory where binary files are downloaded'),
                    service('filesystem'),
                    service('web_asset.binary_provider.registry'),
                    service('web_asset_forge.binary_fetcher'),
                ])
            ->alias(BinaryPathProviderInterface::class, 'web_asset.binary_path.provider')


        /**
         * Binary fetcher
         */
        ->set('web_asset_forge.binary_fetcher.platform_detector', PlatformDetector::class)
            ->alias(PlatformDetectorInterface::class, 'web_asset_forge.binary_fetcher.platform_detector')
        ->set('web_asset_forge.binary_fetcher.event_dispatcher_notifier', BinaryFetcherEventDispatcherNotifier::class)
            ->args([service('event_dispatcher')])
        ->set('web_asset_forge.binary_fetcher', BinaryFetcher::class)
            ->args([
                abstract_arg('directory where binary files are downloaded'),
                service('web_asset_forge.http_client'),
                service('web_asset_forge.binary_fetcher.platform_detector'),
                service('filesystem'),
                service('web_asset_forge.binary_fetcher.event_dispatcher_notifier'),
            ])
            ->alias(BinaryFetcherInterface::class, 'web_asset_forge.binary_fetcher')



        ->set('web_asset_forge.scope.registry', ScopeRegistry::class)
            ->args([abstract_arg('an array of scopes definition')])
            ->lazy()
            ->alias(ScopeRegistryInterface::class, 'web_asset_forge.scope.registry')

        ->set('web_asset_forge.process_provider.install.bun_js', BunJsInstallProcessProvider::class)
            ->args([service('web_asset.binary_path.provider')])

        ->set('web_asset_forge.process_provider.install.pnpm', PnpmInstallProcessProvider::class)
            ->args([service('web_asset.binary_path.provider')])

        ->set('web_asset_forge.command.asset_install', AssetInstallCommand::class)
            ->args([
                service('web_asset_forge.scope.registry'),
                service('event_dispatcher'),
                service('web_asset_forge.process_provider.install.pnpm'),
            ])
            ->tag('console.command')

    ;
};
