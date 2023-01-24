<?php

declare(strict_types=1);

namespace App\Tests\Unit\Account\Balance;

use App\Account\Domain\Money;
use App\Account\Domain\NotEnoughMoneyException;
use App\Tests\Unit\Account\BaseAccountTestCase;

final class TransferTest extends BaseAccountTestCase
{
    public function testBalanceUpdated(): void
    {
        $acc1 = $this->makeAccount(Money::make(100));
        $acc2 = $this->makeAccount();

        $acc1->transfer($acc2, Money::make(20));

        $this->assertTrue($acc1->getBalance()->equals(Money::make(80)));
        $this->assertTrue($acc2->getBalance()->equals(Money::make(20)));
    }

    public function testZeroBalance(): void
    {
        $acc1 = $this->makeAccount();
        $acc2 = $this->makeAccount();

        $this->expectException(NotEnoughMoneyException::class);

        $acc1->transfer($acc2, Money::make(50));
    }

    public function testZeroAmount(): void
    {
        $acc1 = $this->makeAccount(Money::make(100));
        $acc2 = $this->makeAccount();

        $this->expectException(\InvalidArgumentException::class);

        $acc1->transfer($acc2, Money::make(0));
    }

    public function testNegativeAmount(): void
    {
        $acc1 = $this->makeAccount(Money::make(100));
        $acc2 = $this->makeAccount();

        $this->expectException(\InvalidArgumentException::class);

        $acc1->transfer($acc2, Money::make(-10));
    }

    public function testSameAccount(): void
    {
        $acc = $this->makeAccount(Money::make(100));

        $this->expectException(\InvalidArgumentException::class);

        $acc->transfer($acc, Money::make(10));
    }
}
