<?php

declare(strict_types=1);

namespace App\Account\Application\Transfer;

final class Command
{
    public function __construct(
        public readonly string $fromId,
        public readonly string $toId,
        public readonly string $amount
    ) {
    }
}
