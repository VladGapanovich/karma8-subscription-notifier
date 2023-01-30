<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Event;

use Symfony\Component\Messenger\Stamp\StampInterface;

interface EventBus
{
    /**
     * @param StampInterface[] $stamps
     */
    public function handle(Event $event, array $stamps = []): void;
}
