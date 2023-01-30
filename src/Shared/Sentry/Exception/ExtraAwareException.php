<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Sentry\Exception;

use Throwable;

interface ExtraAwareException extends Throwable
{
    /**
     * @return array<string, mixed>
     */
    public function sentryExtra(): array;
}
