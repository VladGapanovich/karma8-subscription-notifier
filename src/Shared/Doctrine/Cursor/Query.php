<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Doctrine\Cursor;

use Doctrine\DBAL\Types\Type;

final class Query
{
    /**
     * @param array<array-key, mixed> $parameters
     * @param array<array-key, int|string|Type|null> $parameterTypes
     */
    public function __construct(
        public readonly string $sql,
        public readonly array $parameters,
        public readonly array $parameterTypes,
    ) {
    }
}
