<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\EmailConfirmationStatus\Domain\Repository;

use Karma8\SubscriptionNotifier\EmailConfirmationStatus\Domain\Exception\EmailConfirmationStatusNotFoundException;
use Karma8\SubscriptionNotifier\EmailConfirmationStatus\Domain\Model\EmailConfirmationStatus;
use Karma8\SubscriptionNotifier\Shared\Model\Email;

interface EmailConfirmationStatusRepository
{
    /**
     * @throws EmailConfirmationStatusNotFoundException
     */
    public function getByEmail(Email $email): EmailConfirmationStatus;

    public function save(EmailConfirmationStatus $emailConfirmationStatus): void;
}
