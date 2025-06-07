<?php

declare(strict_types=1);

namespace WelshTidyMouse\WebAssetForgeBundle\Command;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WelshTidyMouse\BinaryFetcher\Notifier\ConsoleNotifier;
use WelshTidyMouse\WebAssetForgeBundle\Event\BinaryFetcherNotifyEvent;
use WelshTidyMouse\WebAssetForgeBundle\EventListener\BinaryFetcherConsoleEventListener;
use WelshTidyMouse\WebAssetForgeBundle\Provider\Process\PnpnInstallProcessProvider;
use WelshTidyMouse\WebAssetForgeBundle\Registry\ScopeRegistryInterface;

#[AsCommand(name: 'wtm:asset:install', description: 'Install assets')]
final class AssetInstallCommand extends Command
{
    public function __construct(
        private readonly ScopeRegistryInterface $scopeRegistry,
        private readonly EventDispatcherInterface $dispatcher,
        private PnpnInstallProcessProvider $processProvider
    ) {
        parent::__construct();
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $consoleNotifier = new ConsoleNotifier($input, $output);
        $this->dispatcher->addListener(BinaryFetcherNotifyEvent::class, new BinaryFetcherConsoleEventListener($consoleNotifier));


        $output->writeln('Installing assets...');
        $scope = $this->scopeRegistry->get('default');
        $output->writeln(\sprintf('Scope runner: %s', $scope->getRunner()));
        $process = $this->processProvider->provide(getcwd());
        $process->run(function ($type, $buffer) use ($output): void {
            $output->write($buffer);
        });

        return Command::SUCCESS;
    }
}
