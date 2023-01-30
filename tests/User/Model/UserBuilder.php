<?php

declare(strict_types=1);

namespace Tests\Karma8\SubscriptionNotifier\User\Model;

use DateTimeImmutable;
use Karma8\SubscriptionNotifier\Shared\Model\Email;
use Karma8\SubscriptionNotifier\User\Domain\Model\Name;
use Karma8\SubscriptionNotifier\User\Domain\Model\User;
use Karma8\SubscriptionNotifier\User\Domain\Model\UserId;
use Symfony\Component\Uid\UuidV4;
use Tests\Karma8\SubscriptionNotifier\Random;

final class UserBuilder
{
    private UserId $id;
    private Email $email;
    private Name $name;
    private DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->id = new UserId(new UuidV4());
        $this->email = new Email(Random::email());
        $this->name = new Name(Random::string());
        $this->createdAt = new DateTimeImmutable();
    }

    public function withId(UserId $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function withEmail(Email $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function withName(Name $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function withCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function build(): User
    {
        return new User(
            $this->id,
            $this->email,
            $this->name,
            $this->createdAt,
        );
    }
}
