<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\EmailConfirmationStatus\Domain\Model;

use Karma8\SubscriptionNotifier\Shared\Model\Email;

class EmailConfirmationStatus
{
    private readonly int $id;
    private readonly string $email;
    private bool $checked;
    private bool $valid;

    public function __construct(Email $email)
    {
        $this->email = $email->value;
        $this->checked = false;
        $this->valid = false;
    }

    public function changeStatus(bool $valid): void
    {
        $this->checked = true;
        $this->valid = $valid;
    }

    public function isChecked(): bool
    {
        return $this->checked;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }
}
