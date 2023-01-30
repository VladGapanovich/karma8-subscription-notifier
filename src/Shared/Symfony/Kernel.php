<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Symfony;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';
    private const CONFIG_DIRS = '{packages}';

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $confDir = $this->getProjectDir() . '/config';
        $container->import($confDir . '/' . self::CONFIG_DIRS . '/*' . self::CONFIG_EXTS, 'glob');
        $container->import($confDir . '/' . self::CONFIG_DIRS . '/' . $this->debugDir() . '/**/*' . self::CONFIG_EXTS, 'glob');
        $container->import($confDir . '/' . self::CONFIG_DIRS . '/' . $this->environment . '/*' . self::CONFIG_EXTS, 'glob');
        $container->import($confDir . '/' . self::CONFIG_DIRS . '/' . $this->environment . '/' . $this->debugDir() . '/*' . self::CONFIG_EXTS, 'glob');
        $container->import($confDir . '/{services}' . self::CONFIG_EXTS, 'glob');
        $container->import($confDir . '/{services}_' . $this->debugDir() . self::CONFIG_EXTS, 'glob');
        $container->import($confDir . '/{services}_' . $this->environment . '_' . $this->debugDir() . self::CONFIG_EXTS, 'glob');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
    }

    private function debugDir(): string
    {
        return $this->isDebug() ? 'debug' : 'no-debug';
    }
}
