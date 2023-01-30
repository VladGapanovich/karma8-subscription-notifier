<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Messenger\Cqrs\Query;

interface QueryBus
{
    public function handle(Query $query): mixed;
}
