<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Command;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;

final class MessengerCommandBus implements CommandBus
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
    ) {
    }

    /**
     * @param StampInterface[] $stamps
     */
    public function handle(Command|Envelope $command, array $stamps = []): void
    {
        $this->commandBus->dispatch($command, $stamps);
    }
}
