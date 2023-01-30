<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Domain\Exception;

use Karma8\SubscriptionNotifier\User\Domain\Model\UserId;
use RuntimeException;

final class UserNotFoundException extends RuntimeException
{
    public static function createById(UserId $id): self
    {
        return new self(sprintf('User with ID "%s" not found', $id->toString()));
    }
}
