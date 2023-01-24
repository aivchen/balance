<?php

declare(strict_types=1);

namespace App\Account\Domain;

interface Repository
{
    public function findById(Id $id): ?Account;

    /**
     * @throws EntityIsNotFoundException
     */
    public function getById(Id $id): Account;

    public function add(Account $account): void;
}
