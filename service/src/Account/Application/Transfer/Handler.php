<?php

declare(strict_types=1);

namespace App\Account\Application\Transfer;

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
        $from = $this->repository->getById(new Id($command->fromId));
        $to = $this->repository->getById(new Id($command->toId));

        $from->transfer($to, Money::make($command->amount));

        $this->flusher->flush($from);
    }
}
