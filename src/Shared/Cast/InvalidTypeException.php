<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Cast;

use InvalidArgumentException;

final class InvalidTypeException extends InvalidArgumentException
{
    public function __construct(string $expected, string $actual)
    {
        parent::__construct(sprintf('Invalid argument type. Expected %s, got %s.', $expected, $actual));
    }
}
