<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Account\Domain\Account;
use App\Account\Domain\Money;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OptimisticLockTest extends KernelTestCase
{
    public function testDeposit(): void
    {
        self::bootKernel();

        /** @var EntityManagerInterface $em1 */
        $em1 = static::getContainer()->get(EntityManagerInterface::class);
        $em2 = clone $em1;

        /** @var Account $acc1 */
        $acc1 = $em1->find(Account::class, 'user-1');

        /** @var Account $acc2 */
        $acc2 = $em2->find(Account::class, 'user-1');

        $this->assertNotSame($acc1, $acc2);

        $acc1->deposit(Money::make(100));
        $acc2->deposit(Money::make(100));

        $em1->flush();

        $this->expectException(OptimisticLockException::class);

        $em2->flush();
    }
}
