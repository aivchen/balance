<?php

declare(strict_types=1);

namespace App\Messenger\Messages\Commands\Deposit;

use App\Account\Application\Deposit\Command as AccountDepositCommand;
use App\Account\Application\Deposit\Handler as AccountDepositHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class Handler
{
    public function __construct(private readonly AccountDepositHandler $handler)
    {
    }

    public function __invoke(Command $command): void
    {
        $this->handler->handle(new AccountDepositCommand($command->id, $command->amount));
    }
}
