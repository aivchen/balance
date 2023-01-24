<?php

declare(strict_types=1);

namespace App\Messenger\Subscribers;

use App\Account\Domain\Event\MoneyDeposited;
use App\Account\Domain\Event\MoneyTransferred;
use App\Account\Domain\Event\MoneyWithdrew;
use App\Messenger\Messages\Events\MoneyDeposited as ExternalMoneyDeposited;
use App\Messenger\Messages\Events\MoneyTransferred as ExternalMoneyTransferred;
use App\Messenger\Messages\Events\MoneyWithdrew as ExternalMoneyWithdrew;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class AccountEventsSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly MessageBusInterface $eventBus)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MoneyDeposited::class => ['moneyDeposited'],
            MoneyWithdrew::class => ['moneyWithdrew'],
            MoneyTransferred::class => ['moneyTransferred'],
        ];
    }

    public function moneyDeposited(MoneyDeposited $event): void
    {
        $this->eventBus->dispatch(
            new ExternalMoneyDeposited(
                (string)$event->id,
                (string)$event->amount
            )
        );
    }

    public function moneyWithdrew(MoneyWithdrew $event): void
    {
        $this->eventBus->dispatch(
            new ExternalMoneyWithdrew(
                (string)$event->id,
                (string)$event->amount
            )
        );
    }

    public function moneyTransferred(MoneyTransferred $event): void
    {
        $this->eventBus->dispatch(
            new ExternalMoneyTransferred(
                (string)$event->fromId,
                (string)$event->toId,
                (string)$event->amount
            )
        );
    }
}
