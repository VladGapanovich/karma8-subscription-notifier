<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Domain\Repository;

use Karma8\SubscriptionNotifier\User\Domain\Exception\UserNotFoundException;
use Karma8\SubscriptionNotifier\User\Domain\Model\User;
use Karma8\SubscriptionNotifier\User\Domain\Model\UserId;

interface UserRepository
{
    /**
     * @throws UserNotFoundException
     */
    public function getById(UserId $id): User;
}
