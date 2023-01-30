<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Application\SendUsersEmailsAboutAlmostEndedSubscription;

use DateInterval;
use Exception;
use Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Command\CommandBus;
use Karma8\SubscriptionNotifier\User\Application\ScheduleSendUserEmailAboutAlmostEndedSubscription\ScheduleSendUserEmailAboutAlmostEndedSubscriptionCommand;
use Karma8\SubscriptionNotifier\User\Domain\Dao\UserDao;
use Karma8\SubscriptionNotifier\User\Domain\Email\UserSubscriptionAlmostEndsEmailSender;
use League\Period\Period;
use Psr\Clock\ClockInterface;

final class SendUsersEmailsAboutAlmostEndedSubscriptionCommandHandler
{
    private const BATCH_SIZE = 300;

    public function __construct(
        private readonly UserDao $userWithValidEmailRepository,
        private readonly ClockInterface $clock,
        private readonly CommandBus $commandBus,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(SendUsersEmailsAboutAlmostEndedSubscriptionCommand $command): void
    {
        $period = $this->getNotificationPeriod();
        $userIds = $this->userWithValidEmailRepository->getUserIdsSubscriptionEndsInPeriod($period, self::BATCH_SIZE);

        foreach ($userIds as $id) {
            $this->commandBus->handle(new ScheduleSendUserEmailAboutAlmostEndedSubscriptionCommand($id));
        }
    }

    /**
     * @throws Exception
     */
    private function getNotificationPeriod(): Period
    {
        $oneDayInterval = new DateInterval('P1D');
        $tomorrow = $this->clock->now()->add($oneDayInterval);
        $intervalBeforeSubscriptionEnds = new DateInterval(
            sprintf('P%dD', UserSubscriptionAlmostEndsEmailSender::COUNT_OF_DAYS_TO_NOTIFY_ABOUT_END_OF_SUBSCRIPTION),
        );
        $fromDate = $tomorrow->add($intervalBeforeSubscriptionEnds)->setTime(0, 0);
        $endDate = $fromDate->add($oneDayInterval);

        return Period::fromDate($fromDate, $endDate);
    }
}
