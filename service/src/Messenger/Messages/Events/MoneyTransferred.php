<?php

declare(strict_types=1);

namespace App\Messenger\Messages\Events;

use App\Messenger\Messages\Message;

final class MoneyTransferred extends Message
{
    public function __construct(
        public readonly string $fromId,
        public readonly string $toId,
        public readonly string $amount
    ) {
        parent::__construct();
    }

    public static function getName(): string
    {
        return 'MoneyTransferred';
    }
}
