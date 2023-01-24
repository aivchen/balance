<?php

declare(strict_types=1);

namespace App\Messenger\Messages\Events;

use App\Messenger\Messages\Message;

final class MoneyDeposited extends Message
{
    public function __construct(public readonly string $id, public readonly string $amount)
    {
        parent::__construct();
    }

    public static function getName(): string
    {
        return 'MoneyDeposited';
    }
}
