<?php

declare(strict_types=1);

namespace App\Tests\Unit\Account;

use App\Account\Domain\Money;
use PHPUnit\Framework\TestCase;

final class MoneyTest extends TestCase
{
    public function testAmount(): void
    {
        $money = new Money(1);
        $this->assertEquals('1', $money->getAmount());

        $money = new Money('000100');
        $this->assertEquals('100', $money->getAmount());
    }

    public function testInvalidAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Money('aaa');
    }

    public function testNotDecimal(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Money('0xFFFFDEBACDFEDF7200');
    }

    public function testMake(): void
    {
        $money = Money::make(1);
        $this->assertEquals(1, $money->getAmount());

        $money = Money::make('1');
        $this->assertEquals(1, $money->getAmount());
    }

    public function testAdd(): void
    {
        $money = new Money(1);
        self::assertEquals(2, $money->add(Money::make(1))->getAmount());

        $money = (Money::make(PHP_INT_MAX))->add(Money::make(PHP_INT_MAX));
        $this->assertEquals(gmp_strval(gmp_add(PHP_INT_MAX, PHP_INT_MAX)), $money->getAmount());
    }

    public function testSubtract(): void
    {
        $money = new Money(1);
        self::assertEquals(0, $money->subtract(Money::make(1))->getAmount());

        $money = (Money::make(PHP_INT_MIN))->subtract(Money::make(PHP_INT_MAX));
        $this->assertEquals(gmp_strval(gmp_sub(PHP_INT_MIN, PHP_INT_MAX)), $money->getAmount());
    }

    public function testEqual(): void
    {
        $money1 = Money::make(1);

        $this->assertTrue($money1->equals(Money::make(1)));
        $this->assertFalse($money1->equals(Money::make(2)));
    }

    public function testIsLessThan(): void
    {
        $money1 = new Money(1);
        $money2 = new Money(2);

        $this->assertTrue($money1->isLessThan($money2));
        $this->assertFalse($money2->isLessThan($money1));
        $this->assertFalse($money1->isLessThan($money1));
    }

    public function testIsPositive(): void
    {
        $this->assertTrue(Money::make(1)->isPositive());
        $this->assertFalse(Money::make(0)->isPositive());
        $this->assertFalse(Money::make(-1)->isPositive());
    }
}
