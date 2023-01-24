<?php

declare(strict_types=1);

namespace App\Account\Domain\Event;

use App\Account\Domain\Id;
use App\Account\Domain\Money;

class MoneyDeposited
{
    public function __construct(public readonly Id $id, public readonly Money $amount)
    {
    }
}
