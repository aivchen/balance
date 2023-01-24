<?php

declare(strict_types=1);

namespace App\Account\Application\Withdraw;

final class Command
{
    public function __construct(public readonly string $id, public readonly string $amount)
    {
    }
}
