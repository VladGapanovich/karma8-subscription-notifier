<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Infrastructure\EmailSender;

use Karma8\SubscriptionNotifier\Shared\Model\Email;
use Karma8\SubscriptionNotifier\User\Domain\Email\UserSubscriptionAlmostEndsEmailSender;
use Karma8\SubscriptionNotifier\User\Domain\Model\Name;

final class RealUserSubscriptionAlmostEndsEmailSender implements UserSubscriptionAlmostEndsEmailSender
{
    public function send(Email $email, Name $name): void
    {
        sleep(random_int(0, 10));
    }
}
