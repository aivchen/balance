<?php

declare(strict_types=1);

namespace App\Account\Domain;

use App\Account\Domain\Event\MoneyDeposited;
use App\Account\Domain\Event\MoneyTransferred;
use App\Account\Domain\Event\MoneyWithdrew;

class Account implements EventsReleasable
{
    private Id $id;

    private Money $balance;

    /** @var object[] */
    private array $events = [];

    private int $version = 1;

    public function __construct(Id $id, Money $balance = new Money(0))
    {
        $this->id = $id;
        $this->balance = $balance;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getBalance(): Money
    {
        return $this->balance;
    }

    public function deposit(Money $amount): void
    {
        $this->ensureAmountIsPositive($amount);
        $this->balance = $this->balance->add($amount);
        $this->addEvent(new MoneyDeposited($this->id, $amount));
    }

    public function withdraw(Money $amount): void
    {
        $this->ensureAmountIsPositive($amount);
        $this->ensureEnoughMoney($amount);
        $this->balance = $this->balance->subtract($amount);
        $this->addEvent(new MoneyWithdrew($this->id, $amount));
    }

    public function transfer(Account $account, Money $amount): void
    {
        if ($this->id->equals($account->id)) {
            throw new \InvalidArgumentException('You can\'t transfer to yourself');
        }
        $this->ensureAmountIsPositive($amount);
        $this->ensureEnoughMoney($amount);

        $this->balance = $this->balance->subtract($amount);
        $account->balance = $account->balance->add($amount);

        $this->addEvent(new MoneyTransferred($this->id, $account->id, $amount));
    }

    private function addEvent(object $event): void
    {
        $this->events[] = $event;
    }

    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

    public function ensureAmountIsPositive(Money $amount): void
    {
        if (!$amount->isPositive()) {
            throw new \InvalidArgumentException("Negative or zero amount is not allowed");
        }
    }

    private function ensureEnoughMoney(Money $amount): void
    {
        if ($this->balance->isLessThan($amount)) {
            throw new NotEnoughMoneyException();
        }
    }
}
