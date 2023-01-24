<?php

declare(strict_types=1);

namespace App\Account\Domain;

/**
 * @psalm-immutable
 */
class Money implements \Stringable
{
    private readonly \GMP $amount;

    public function __construct(string|int $amount)
    {
        $amount = (string)$amount;

        try {
            $this->amount = gmp_init($amount, 10);
        } catch (\ValueError) {
            throw new \InvalidArgumentException();
        }
    }

    public static function make(int|string $val): Money
    {
        return new self($val);
    }

    public function getAmount(): string
    {
        return gmp_strval($this->amount);
    }

    public function equals(Money $money): bool
    {
        return gmp_cmp($this->amount, $money->amount) === 0;
    }

    public function add(Money $money): Money
    {
        return new self(gmp_strval(gmp_add($this->amount, $money->amount)));
    }

    public function subtract(Money $money): Money
    {
        return new self(gmp_strval(gmp_sub($this->amount, $money->amount)));
    }

    public function isLessThan(Money $money): bool
    {
        return gmp_cmp($this->amount, $money->amount) < 0;
    }

    public function isPositive(): bool
    {
        return gmp_cmp($this->amount, 0) > 0;
    }

    public function __toString(): string
    {
        return $this->getAmount();
    }
}
