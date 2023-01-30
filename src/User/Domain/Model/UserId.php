<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Domain\Model;

use Symfony\Component\Uid\UuidV4;

final class UserId
{
    public function __construct(
        public readonly UuidV4 $value,
    ) {
    }

    public function toString(): string
    {
        return $this->value->toRfc4122();
    }
}
