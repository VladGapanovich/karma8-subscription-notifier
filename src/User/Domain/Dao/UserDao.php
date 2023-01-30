<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Domain\Dao;

use Generator;
use Karma8\SubscriptionNotifier\User\Domain\Model\UserId;
use League\Period\Period;

interface UserDao
{
    /**
     * @return Generator<UserId>
     */
    public function getUserIdsSubscriptionEndsInPeriod(Period $period, int $batchSize): Generator;
}
