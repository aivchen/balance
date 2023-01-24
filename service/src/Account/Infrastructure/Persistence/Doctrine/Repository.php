<?php

declare(strict_types=1);

namespace App\Account\Infrastructure\Persistence\Doctrine;

use App\Account\Domain\Account;
use App\Account\Domain\EntityIsNotFoundException;
use App\Account\Domain\Id;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class Repository implements \App\Account\Domain\Repository
{
    /** @var EntityRepository<Account> */
    private EntityRepository $repo;

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Account::class);
        $this->em = $em;
    }

    public function findById(Id $id): ?Account
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function add(Account $account): void
    {
        $this->em->persist($account);
    }

    public function getById(Id $id): Account
    {
        $model = $this->findById($id);
        if ($model === null) {
            throw new EntityIsNotFoundException("Account $id is not found.");
        }
        return $model;
    }
}
