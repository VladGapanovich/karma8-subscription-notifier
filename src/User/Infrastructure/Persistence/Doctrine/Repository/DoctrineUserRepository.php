<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Karma8\SubscriptionNotifier\User\Domain\Exception\UserNotFoundException;
use Karma8\SubscriptionNotifier\User\Domain\Model\User;
use Karma8\SubscriptionNotifier\User\Domain\Model\UserId;
use Karma8\SubscriptionNotifier\User\Domain\Repository\UserRepository;

/**
 * @template-extends ServiceEntityRepository<User>
 */
final class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getById(UserId $id): User
    {
        $user = $this->find($id->toString());

        if (!$user instanceof User) {
            throw UserNotFoundException::createById($id);
        }

        return $user;
    }
}
