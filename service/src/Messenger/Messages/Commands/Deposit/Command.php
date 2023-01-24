<?php

declare(strict_types=1);

namespace App\Messenger\Messages\Commands\Deposit;

use App\Messenger\Messages\Message;

final class Command extends Message
{
    public function __construct(public readonly string $id, public readonly string $amount)
    {
        parent::__construct();
    }

    public static function getName(): string
    {
        return 'Deposit';
    }
}
