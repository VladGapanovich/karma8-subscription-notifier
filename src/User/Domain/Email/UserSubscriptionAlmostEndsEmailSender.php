<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Domain\Email;

use Karma8\SubscriptionNotifier\Shared\Model\Email;
use Karma8\SubscriptionNotifier\User\Domain\Model\Name;

interface UserSubscriptionAlmostEndsEmailSender
{
    public const COUNT_OF_DAYS_TO_NOTIFY_ABOUT_END_OF_SUBSCRIPTION = 3;
    public const COUNT_OF_SECONDS_TO_NOTIFY_ABOUT_END_OF_SUBSCRIPTION = 60 * 60 * 24 * self::COUNT_OF_DAYS_TO_NOTIFY_ABOUT_END_OF_SUBSCRIPTION;

    public function send(Email $email, Name $name): void;
}
