<?php

declare(strict_types=1);

namespace App\Account\Domain\Event;

use App\Account\Domain\Id;
use App\Account\Domain\Money;

class MoneyTransferred
{
    public function __construct(
        public readonly Id $fromId,
        public readonly Id $toId,
        public readonly Money $amount
    ) {
    }
}
