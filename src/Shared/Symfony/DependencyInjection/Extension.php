<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Symfony\DependencyInjection;

use Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Command\CommandHandler;
use Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Event\EventHandler;
use Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Query\QueryHandler;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

final class Extension extends ConfigurableExtension
{
    public function __construct(
        private readonly string $alias,
    ) {
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @param mixed[] $config
     */
    public function getConfiguration(array $config, ContainerBuilder $container): ConfigurationInterface
    {
        return new Configuration($this->alias);
    }

    /**
     * @param mixed[] $mergedConfig
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(CommandHandler::class)
            ->addTag('messenger.message_handler', ['bus' => 'command.bus']);
        $container->registerForAutoconfiguration(QueryHandler::class)
            ->addTag('messenger.message_handler', ['bus' => 'query.bus']);
        $container->registerForAutoconfiguration(EventHandler::class)
            ->addTag('messenger.message_handler', ['bus' => 'event.bus']);
    }
}
