<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Application\SendUserEmailAboutAlmostEndedSubscription;

use Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Command\Command;
use Karma8\SubscriptionNotifier\Shared\Model\Email;
use Karma8\SubscriptionNotifier\User\Domain\Model\Name;

/**
 * @see SendUserEmailAboutAlmostEndedSubscriptionCommandHandler
 */
final class SendUserEmailAboutAlmostEndedSubscriptionCommand implements Command
{
    public function __construct(
        public readonly Email $email,
        public readonly Name $name,
    ) {
    }
}
