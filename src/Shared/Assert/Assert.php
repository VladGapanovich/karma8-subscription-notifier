<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Assert;

use Webmozart\Assert\Assert as BaseAssert;

final class Assert extends BaseAssert
{
    protected static function reportInvalidArgument($message): void
    {
        throw new ValidationFailedException($message);
    }
}
