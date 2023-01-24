<?php

declare(strict_types=1);

namespace App\Account\Application\Deposit;

use App\Account\Domain\Account;
use App\Account\Domain\Flusher;
use App\Account\Domain\Id;
use App\Account\Domain\Money;
use App\Account\Domain\Repository;

final class Handler
{
    public function __construct(private readonly Repository $repository, private readonly Flusher $flusher)
    {
    }

    public function handle(Command $command): void
    {
        $id = new Id($command->id);

        $account = $this->repository->findById($id);

        if ($account === null) {
            $account = new Account($id);
            $this->repository->add($account);
        }

        $account->deposit(Money::make($command->amount));

        $this->flusher->flush($account);
    }
}
