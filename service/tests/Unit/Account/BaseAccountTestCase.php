<?php

declare(strict_types=1);

namespace App\Tests\Unit\Account;

use App\Account\Domain\Account;
use App\Account\Domain\Id;
use App\Account\Domain\Money;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class BaseAccountTestCase extends TestCase
{
    protected function makeAccount(Money $money = new Money(0)): Account
    {
        return new Account(new Id(Uuid::v7()->toRfc4122()), $money);
    }
}
