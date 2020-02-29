<?php

namespace Study\User\Domain\Repository\Infrastructure\Doctrine;

use Doctrine\Persistence\ManagerRegistry;
use Study\Common\Domain\Repository\Infrastructure\Doctrine\AbstractDoctrineRepository;
use Study\User\Domain\Model\Infrastructure\Doctrine\DoctrineUser;
use Study\User\Domain\Model\User;
use Study\User\Domain\Repository\UserRepository;

class DoctrineUserRepository extends AbstractDoctrineRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass = DoctrineUser::class)
    {
        parent::__construct($registry, $entityClass);
    }

    public function byEmail(string $email): ?User
    {
        return $this->repository()->findOneBy(['email' => trim($email)]);
    }
}
