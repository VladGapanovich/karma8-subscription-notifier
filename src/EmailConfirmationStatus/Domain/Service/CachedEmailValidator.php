<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\EmailConfirmationStatus\Domain\Service;

use Karma8\SubscriptionNotifier\EmailConfirmationStatus\Domain\Repository\EmailConfirmationStatusRepository;
use Karma8\SubscriptionNotifier\Shared\Model\Email;

final class CachedEmailValidator implements EmailValidator
{
    public function __construct(
        private readonly EmailValidator $emailValidator,
        private readonly EmailConfirmationStatusRepository $emailConfirmationStatusRepository,
    ) {
    }

    public function isValid(Email $email): bool
    {
        $emailConfirmationStatus = $this->emailConfirmationStatusRepository->getByEmail($email);

        if ($emailConfirmationStatus->isChecked()) {
            return $emailConfirmationStatus->isValid();
        }

        $valid = $this->emailValidator->isValid($email);

        $emailConfirmationStatus->changeStatus($valid);
        $this->emailConfirmationStatusRepository->save($emailConfirmationStatus);

        return $valid;
    }
}
