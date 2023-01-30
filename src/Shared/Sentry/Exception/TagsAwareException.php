<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Sentry\Exception;

use Throwable;

interface TagsAwareException extends Throwable
{
    /**
     * @return array<string, string|int|float|bool>
     */
    public function sentryTags(): array;
}
