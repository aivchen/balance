<?php

declare(strict_types=1);

namespace App\Messenger\Messages;

abstract class Message
{
    public string $name;

    public function __construct()
    {
        $this->name = static::getName();
    }

    abstract public static function getName(): string;
}
