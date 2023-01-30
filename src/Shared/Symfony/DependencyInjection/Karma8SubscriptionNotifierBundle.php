<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Symfony\DependencyInjection;

use Symfony\Component\HttpKernel\Bundle\Bundle;

final class Karma8SubscriptionNotifierBundle extends Bundle
{
    public function getContainerExtension(): Extension
    {
        return new Extension('app');
    }
}
