<?php

declare(strict_types=1);

namespace App\Account\DataFixtures;

use App\Account\Domain\Account;
use App\Account\Domain\Id;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AccountFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $acc1 = $this->makeAccount('user-1');
        $acc2 = $this->makeAccount('user-2');

        $manager->persist($acc1);
        $manager->persist($acc2);

        $manager->flush();
    }

    private function makeAccount(string $id): Account
    {
        return new Account(new Id($id));
    }
}
