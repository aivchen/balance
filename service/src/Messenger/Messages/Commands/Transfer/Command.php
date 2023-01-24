<?php

declare(strict_types=1);

namespace App\Messenger\Messages\Commands\Transfer;

use App\Messenger\Messages\Message;

final class Command extends Message
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
        return 'Transfer';
    }
}
