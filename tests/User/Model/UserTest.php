<?php

declare(strict_types=1);

namespace Tests\Karma8\SubscriptionNotifier\User\Model;

use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    /**
     * @test
     */
    public function user_gets_seconds_before_end_of_subscription(): void
    {
        $now = new DateTimeImmutable();
        $sut = (new UserBuilder())
            ->withCreatedAt($now)
            ->build();
        $sut->paySubscription($now->add(new DateInterval('PT10S')));

        $result = $sut->getSecondsBeforeEndOfSubscription($now);

        self::assertSame(10, $result);
    }
}
