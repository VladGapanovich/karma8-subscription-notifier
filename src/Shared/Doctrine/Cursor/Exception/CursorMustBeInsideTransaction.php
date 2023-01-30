<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Doctrine\Cursor\Exception;

use BadMethodCallException;

final class CursorMustBeInsideTransaction extends BadMethodCallException
{
    public function __construct()
    {
        parent::__construct('Cursor must be used inside a transaction');
    }
}
