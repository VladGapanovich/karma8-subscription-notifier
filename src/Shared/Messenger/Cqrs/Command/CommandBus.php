<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Command;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\StampInterface;

interface CommandBus
{
    /**
     * @param StampInterface[] $stamps
     */
    public function handle(Command|Envelope $command, array $stamps = []): void;
}
