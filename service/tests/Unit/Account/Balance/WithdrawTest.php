<?php

declare(strict_types=1);

namespace App\Tests\Unit\Account\Balance;

use App\Account\Domain\Money;
use App\Account\Domain\NotEnoughMoneyException;
use App\Tests\Unit\Account\BaseAccountTestCase;

final class WithdrawTest extends BaseAccountTestCase
{
    public function testWithdraw(): void
    {
        $account = $this->makeAccount(Money::make(100));

        $account->withdraw(Money::make(40));

        $this->assertTrue($account->getBalance()->equals(Money::make(60)));
    }

    public function testZero(): void
    {
        $account = $this->makeAccount(Money::make(100));

        $this->expectException(\InvalidArgumentException::class);

        $account->withdraw(Money::make(-40));
    }

    public function testNegative(): void
    {
        $account = $this->makeAccount(Money::make(100));

        $this->expectException(\InvalidArgumentException::class);

        $account->withdraw(Money::make(0));
    }

    public function testWithdrawZeroBalance(): void
    {
        $account = $this->makeAccount();

        $this->expectException(NotEnoughMoneyException::class);

        $account->withdraw(Money::make(100));
    }
}
