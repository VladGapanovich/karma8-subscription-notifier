<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\EmailConfirmationStatus\Domain\Service;

use Karma8\SubscriptionNotifier\Shared\Model\Email;

interface EmailValidator
{
    public function isValid(Email $email): bool;
}
