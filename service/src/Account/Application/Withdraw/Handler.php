<?php

declare(strict_types=1);

namespace App\Account\Application\Withdraw;

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

        $account = $this->repository->getById($id);

        $account->withdraw(Money::make($command->amount));

        $this->flusher->flush($account);
    }
}
