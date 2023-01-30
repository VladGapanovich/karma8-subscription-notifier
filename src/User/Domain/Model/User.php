<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\User\Domain\Model;

use DateTimeImmutable;
use Karma8\SubscriptionNotifier\Shared\Model\Email;
use Symfony\Component\Uid\UuidV4;

class User
{
    private readonly UuidV4 $id;
    private readonly string $email;
    private string $name;
    private readonly DateTimeImmutable $createdAt;
    private bool $confirmed;
    private ?DateTimeImmutable $subscriptionEndsAt;

    public function __construct(
        UserId $id,
        Email $email,
        Name $name,
        DateTimeImmutable $createdAt,
    ) {
        $this->id = $id->value;
        $this->email = $email->value;
        $this->name = $name->value;
        $this->createdAt = $createdAt;
        $this->confirmed = false;
        $this->subscriptionEndsAt = null;
    }

    public function paySubscription(DateTimeImmutable $subscriptionEndsAt): void
    {
        $this->subscriptionEndsAt = $subscriptionEndsAt;
    }

    public function getSecondsBeforeEndOfSubscription(DateTimeImmutable $now): int
    {
        $subscriptionEndsTimestamp = $this->subscriptionEndsAt?->getTimestamp() ?? 0;

        return $subscriptionEndsTimestamp - $now->getTimestamp();
    }

    public function email(): Email
    {
        return new Email($this->email);
    }

    public function name(): Name
    {
        return new Name($this->name);
    }
}
