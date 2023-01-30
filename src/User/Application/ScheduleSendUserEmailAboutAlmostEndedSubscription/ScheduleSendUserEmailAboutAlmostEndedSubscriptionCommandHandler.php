<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Application\ScheduleSendUserEmailAboutAlmostEndedSubscription;

use Exception;
use Karma8\SubscriptionNotifier\EmailConfirmationStatus\Domain\Service\EmailValidator;
use Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Command\CommandBus;
use Karma8\SubscriptionNotifier\User\Application\SendUserEmailAboutAlmostEndedSubscription\SendUserEmailAboutAlmostEndedSubscriptionCommand;
use Karma8\SubscriptionNotifier\User\Domain\Email\UserSubscriptionAlmostEndsEmailSender;
use Karma8\SubscriptionNotifier\User\Domain\Repository\UserRepository;
use Psr\Clock\ClockInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

final class ScheduleSendUserEmailAboutAlmostEndedSubscriptionCommandHandler
{
    public function __construct(
        private readonly EmailValidator $emailValidator,
        private readonly UserRepository $userRepository,
        private readonly ClockInterface $clock,
        private readonly CommandBus $commandBus,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(ScheduleSendUserEmailAboutAlmostEndedSubscriptionCommand $command): void
    {
        $user = $this->userRepository->getById($command->userId);

        if ($this->emailValidator->isValid($user->email())) {
            $now = $this->clock->now();
            $secondsBeforeEndOfSubscription = $user->getSecondsBeforeEndOfSubscription($now);
            $secondsToNotification = $secondsBeforeEndOfSubscription - UserSubscriptionAlmostEndsEmailSender::COUNT_OF_SECONDS_TO_NOTIFY_ABOUT_END_OF_SUBSCRIPTION;

            $this->commandBus->handle(
                new SendUserEmailAboutAlmostEndedSubscriptionCommand($user->email(), $user->name()),
                [new DelayStamp($secondsToNotification)],
            );
        }
    }
}
