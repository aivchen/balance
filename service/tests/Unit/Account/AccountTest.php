<?php

declare(strict_types=1);

namespace App\Tests\Unit\Account;

final class AccountTest extends BaseAccountTestCase
{
    public function testInit(): void
    {
        $account = $this->makeAccount();

        $this->assertEquals(0, $account->getBalance()->getAmount());
    }
}
