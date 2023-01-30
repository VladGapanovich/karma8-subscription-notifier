<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\EmailConfirmationStatus\Domain\Exception;

use Karma8\SubscriptionNotifier\Shared\Model\Email;
use RuntimeException;

final class EmailConfirmationStatusNotFoundException extends RuntimeException
{
    public static function createByEmail(Email $email): self
    {
        return new self(sprintf('Email confirmation status for email "%s" not found', $email->value));
    }
}
