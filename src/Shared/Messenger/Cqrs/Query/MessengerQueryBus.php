<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Query;

use Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Query\Exception\InvalidQueryHandlerCountException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class MessengerQueryBus implements QueryBus
{
    public function __construct(
        private readonly MessageBusInterface $queryBus,
    ) {
    }

    public function handle(Query $query): mixed
    {
        $envelope = $this->queryBus->dispatch($query);

        /** @var HandledStamp[] $handledStamps */
        $handledStamps = $envelope->all(HandledStamp::class);
        $countOfHandledStamps = \count($handledStamps);

        if (0 === $countOfHandledStamps) {
            throw InvalidQueryHandlerCountException::zero($envelope);
        }

        if ($countOfHandledStamps > 1) {
            $handlerNames = array_map(
                static fn (HandledStamp $stamp): string => sprintf('"%s"', $stamp->getHandlerName()),
                $handledStamps,
            );

            throw InvalidQueryHandlerCountException::moreThanOne($envelope, $countOfHandledStamps, $handlerNames);
        }

        return $handledStamps[0]->getResult();
    }
}
