<?php

declare(strict_types=1);

namespace App\Account\Domain;

interface EventsReleasable
{
    /**
     * @return object[]
     */
    public function releaseEvents(): array;
}
