<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Domain\Model;

use Karma8\SubscriptionNotifier\Shared\Assert\Assert;

final class Name
{
    private const MIN_LENGTH = 1;

    public readonly string $value;

    public function __construct(string $value)
    {
        $this->value = trim($value);

        Assert::minLength($this->value, self::MIN_LENGTH);
    }
}
