<?php

declare(strict_types=1);

namespace App\Account\Infrastructure\Persistence\Doctrine;

use App\Account\Domain\EventsReleasable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class Flusher implements \App\Account\Domain\Flusher
{
    public function __construct(private readonly EntityManagerInterface $em, private readonly EventDispatcherInterface $dispatcher)
    {
    }

    public function flush(EventsReleasable ...$entities): void
    {
        $this->em->flush();

        foreach ($entities as $entity) {
            foreach ($entity->releaseEvents() as $event) {
                $this->dispatcher->dispatch($event);
            }
        }
    }
}
