<?php

declare(strict_types=1);

namespace App\Messenger\Messages\Commands\Withdraw;

use App\Account\Application\Withdraw\Command as WithdrawCommand;
use App\Account\Application\Withdraw\Handler as WithdrawHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class Handler
{
    public function __construct(private readonly WithdrawHandler $handler)
    {
    }

    public function __invoke(Command $command): void
    {
        $this->handler->handle(new WithdrawCommand($command->id, $command->amount));
    }
}
