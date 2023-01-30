<?php

declare(strict_types=1);

namespace Tests\Karma8\SubscriptionNotifier\EmailConfirmationStatus\Model;

use Karma8\SubscriptionNotifier\EmailConfirmationStatus\Domain\Model\EmailConfirmationStatus;
use Karma8\SubscriptionNotifier\Shared\Model\Email;
use PHPUnit\Framework\TestCase;
use Tests\Karma8\SubscriptionNotifier\Random;

final class EmailConfirmationStatusTest extends TestCase
{
    /**
     * @test
     */
    public function email_confirmation_status_changes_status(): void
    {
        $sut = new EmailConfirmationStatus(new Email(Random::email()));

        $sut->changeStatus(true);

        self::assertSame(true, $sut->isChecked());
        self::assertSame(true, $sut->isValid());
    }
}
