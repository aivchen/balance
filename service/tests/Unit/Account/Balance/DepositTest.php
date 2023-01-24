<?php

declare(strict_types=1);

namespace App\Tests\Unit\Account\Balance;

use App\Account\Domain\Money;
use App\Tests\Unit\Account\BaseAccountTestCase;

final class DepositTest extends BaseAccountTestCase
{
    public function testDeposit(): void
    {
        $account = $this->makeAccount();
        $account->deposit($deposit = Money::make(100));

        $this->assertTrue($deposit->equals($account->getBalance()));
    }

    public function testDepositZero(): void
    {
        $account = $this->makeAccount();

        $this->expectException(\InvalidArgumentException::class);

        $account->deposit(Money::make(0));
    }

    public function testDepositNegative(): void
    {
        $account = $this->makeAccount();

        $this->expectException(\InvalidArgumentException::class);

        $account->deposit(Money::make(-100));
    }
}
