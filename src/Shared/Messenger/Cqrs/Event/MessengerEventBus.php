<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Event;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;

final class MessengerEventBus implements EventBus
{
    public function __construct(
        private readonly MessageBusInterface $eventBus,
    ) {
    }

    /**
     * @param StampInterface[] $stamps
     */
    public function handle(Event $event, array $stamps = []): void
    {
        $this->eventBus->dispatch($event, $stamps);
    }
}
