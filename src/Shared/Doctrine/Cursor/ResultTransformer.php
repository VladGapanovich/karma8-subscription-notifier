<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Doctrine\Cursor;

interface ResultTransformer
{
    /**
     * @param array<string, mixed> $data
     */
    public function transform(array $data): mixed;
}
