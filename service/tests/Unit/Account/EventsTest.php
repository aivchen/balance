<?php

namespace App\Tests\Unit\Account;

use App\Account\Domain\Account;
use App\Account\Domain\Event\MoneyDeposited;
use App\Account\Domain\Event\MoneyTransferred;
use App\Account\Domain\Event\MoneyWithdrew;
use App\Account\Domain\Money;

final class EventsTest extends BaseAccountTestCase
{
    public function testDeposit(): void
    {
        $account = $this->makeAccount();
        $amount = Money::make(100);

        $account->deposit($amount);
        /** @var MoneyDeposited $event */
        $event = $this->getSingleEvent($account, MoneyDeposited::class);

        $this->assertTrue($account->getId()->equals($event->id));
        $this->assertTrue($amount->equals($event->amount));
    }

    public function testWithdraw(): void
    {
        $account = $this->makeAccount(Money::make(100));

        $account->withdraw($amount = Money::make(40));
        /** @var MoneyWithdrew $event */
        $event = $this->getSingleEvent($account, MoneyWithdrew::class);

        $this->assertTrue($account->getId()->equals($event->id));
        $this->assertTrue($amount->equals($event->amount));
    }

    public function testTransfer(): void
    {
        $acc1 = $this->makeAccount(Money::make(100));
        $acc2 = $this->makeAccount(Money::make(100));

        $acc1->transfer($acc2, $amount = Money::make(40));

        /** @var MoneyTransferred $event */
        $event = $this->getSingleEvent($acc1, MoneyTransferred::class);

        $this->assertTrue($acc1->getId()->equals($event->fromId));
        $this->assertTrue($acc2->getId()->equals($event->toId));
        $this->assertTrue($amount->equals($event->amount));
    }

    /**
     * @param class-string $className
     */
    private function getSingleEvent(Account $account, string $className): object
    {
        $events = $account->releaseEvents();

        $this->assertCount(1, $events);
        $this->assertInstanceOf($className, $events[0]);
        return $events[0];
    }
}
