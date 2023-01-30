<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Infrastructure\Persistence\Doctrine\Dao\Transformers;

use Karma8\SubscriptionNotifier\Shared\Cast\Cast;
use Karma8\SubscriptionNotifier\Shared\Doctrine\Cursor\ResultTransformer;
use Karma8\SubscriptionNotifier\User\Domain\Model\UserId;
use Symfony\Component\Uid\UuidV4;

final class UserIdResultTransformer implements ResultTransformer
{
    /**
     * @param array<string, mixed> $data
     */
    public function transform(array $data): UserId
    {
        return new UserId(UuidV4::fromString(Cast::string($data['id'])));
    }
}
