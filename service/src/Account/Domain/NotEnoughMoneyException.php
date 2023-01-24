<?php

declare(strict_types=1);

namespace App\Account\Domain;

use Throwable;

class NotEnoughMoneyException extends \DomainException
{
    public function __construct(string $message = "Not Enough Money", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
