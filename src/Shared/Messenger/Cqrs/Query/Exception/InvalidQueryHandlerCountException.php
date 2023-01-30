<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Query\Exception;

use LogicException;
use Symfony\Component\Messenger\Envelope;

final class InvalidQueryHandlerCountException extends LogicException
{
    public static function zero(Envelope $envelope): self
    {
        return new self(sprintf('Query of type "%s" was handled zero times.', get_debug_type($envelope->getMessage())));
    }

    /**
     * @param string[] $handlerNames
     */
    public static function moreThanOne(Envelope $envelope, int $countOfHandledStamps, array $handlerNames): self
    {
        return new self(sprintf('Message of type "%s" was handled multiple times. Only one handler is expected, got %d: %s.', get_debug_type($envelope->getMessage()), $countOfHandledStamps, implode(', ', $handlerNames)));
    }
}
