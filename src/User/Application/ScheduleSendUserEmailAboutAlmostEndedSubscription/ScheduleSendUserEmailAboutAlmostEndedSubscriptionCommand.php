<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Application\ScheduleSendUserEmailAboutAlmostEndedSubscription;

use Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Command\Command;
use Karma8\SubscriptionNotifier\User\Domain\Model\UserId;

/**
 * @see ScheduleSendUserEmailAboutAlmostEndedSubscriptionCommandHandler
 */
final class ScheduleSendUserEmailAboutAlmostEndedSubscriptionCommand implements Command
{
    public function __construct(
        public readonly UserId $userId,
    ) {
    }
}
