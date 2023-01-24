<?php

declare(strict_types=1);

namespace App\Messenger\Messages\Commands\Transfer;

use App\Account\Application\Transfer\Command as TransferCommand;
use App\Account\Application\Transfer\Handler as TransferHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class Handler
{
    public function __construct(private readonly TransferHandler $handler)
    {
    }

    public function __invoke(Command $command): void
    {
        $this->handler->handle(new TransferCommand($command->fromId, $command->toId, $command->amount));
    }
}
