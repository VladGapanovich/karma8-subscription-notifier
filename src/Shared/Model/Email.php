<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Model;

use Karma8\SubscriptionNotifier\Shared\Assert\Assert;

final class Email
{
    public readonly string $value;

    public function __construct(string $value)
    {
        $this->value = trim($value);

        Assert::email($this->value);
    }
}
