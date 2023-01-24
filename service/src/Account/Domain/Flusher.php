<?php

declare(strict_types=1);

namespace App\Account\Domain;

interface Flusher
{
    public function flush(EventsReleasable ...$entities): void;
}
