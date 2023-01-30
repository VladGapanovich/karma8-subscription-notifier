<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function __construct(
        private readonly string $alias,
    ) {
    }

    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder($this->alias);
    }
}
