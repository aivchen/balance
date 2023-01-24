<?php

declare(strict_types=1);

namespace App\Account\Domain;

use Stringable;

class Id implements Stringable
{
    private readonly string $val;

    public function __construct(string $val)
    {
        $this->val = $val;
    }

    public function __toString(): string
    {
        return $this->val;
    }

    public function equals(Id $id): bool
    {
        return $this->val === $id->val;
    }
}
