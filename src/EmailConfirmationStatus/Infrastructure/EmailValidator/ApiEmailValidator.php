<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\EmailConfirmationStatus\Infrastructure\EmailValidator;

use Karma8\SubscriptionNotifier\EmailConfirmationStatus\Domain\Service\EmailValidator;
use Karma8\SubscriptionNotifier\Shared\Model\Email;

final class ApiEmailValidator implements EmailValidator
{
    public function isValid(Email $email): bool
    {
        sleep(random_int(1, 60));

        return (bool) random_int(0, 1);
    }
}
