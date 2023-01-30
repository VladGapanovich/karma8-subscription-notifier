<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Application\SendUserEmailAboutAlmostEndedSubscription;

use Exception;
use Karma8\SubscriptionNotifier\User\Domain\Email\UserSubscriptionAlmostEndsEmailSender;

final class SendUserEmailAboutAlmostEndedSubscriptionCommandHandler
{
    public function __construct(
        private readonly UserSubscriptionAlmostEndsEmailSender $userSubscriptionAlmostEndsEmailSender,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(SendUserEmailAboutAlmostEndedSubscriptionCommand $command): void
    {
        $this->userSubscriptionAlmostEndsEmailSender->send($command->email, $command->name);
    }
}
