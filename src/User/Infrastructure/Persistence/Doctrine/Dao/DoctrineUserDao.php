<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Infrastructure\Persistence\Doctrine\Dao;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Generator;
use Karma8\SubscriptionNotifier\Shared\Doctrine\Cursor\DoctrineMysqlCursor;
use Karma8\SubscriptionNotifier\User\Domain\Dao\UserDao;
use Karma8\SubscriptionNotifier\User\Domain\Model\UserId;
use Karma8\SubscriptionNotifier\User\Infrastructure\Persistence\Doctrine\Dao\Transformers\UserIdResultTransformer;
use League\Period\Period;

final class DoctrineUserDao implements UserDao
{
    public function __construct(
        private readonly Connection $connection,
        private readonly UserIdResultTransformer $userWithValidEmailResultTransformer,
    ) {
    }

    /**
     * @return Generator<UserId>
     *
     * @throws Exception
     */
    public function getUserIdsSubscriptionEndsInPeriod(Period $period, int $batchSize): Generator
    {
        $qb = $this->connection->createQueryBuilder()
            ->select('user.id as id')
            ->from('karma8_sn_users', 'user')
            ->innerJoin(
                'user',
                'karma8_sn_email_confirmation_statuses',
                'email_confirmation_status',
                'user.email = email_confirmation_status.email',
            )
            ->andWhere('user.confirmed = :confirmed')
            ->andWhere('email_confirmation_status.valid = :valid')
            ->andWhere(sprintf('users.subscription_ends_at %s :fromDate', $period->bounds->isStartIncluded() ? '>=' : '>'))
            ->andWhere(sprintf('users.subscription_ends_at %s :tillDate', $period->bounds->isEndIncluded() ? '<=' : '<'))
            ->setParameter('confirmed', true)
            ->setParameter('valid', true)
            ->setParameter('fromDate', $period->startDate->format('Y-m-d H:i:s'))
            ->setParameter('tillDate', $period->endDate->format('Y-m-d H:i:s'));
        $cursor = new DoctrineMysqlCursor($this->connection, $qb, $this->userWithValidEmailResultTransformer);

        return $cursor->fetch($batchSize);
    }
}
