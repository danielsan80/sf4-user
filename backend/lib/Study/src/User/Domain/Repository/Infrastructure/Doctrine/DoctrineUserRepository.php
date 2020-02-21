<?php

namespace Study\User\Domain\Repository\Infrastructure\Doctrine;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Study\Common\Domain\Repository\Infrastructure\Doctrine\AbstractDoctrineRepository;
use Study\User\Domain\Model\Infrastructure\Doctrine\DoctrineUser;
use Study\User\Domain\Model\User;
use Study\User\Domain\Repository\UserRepository;

class DoctrineUserRepository extends AbstractDoctrineRepository implements UserRepository
{

    /** @var ManagerRegistry */
    protected $registry;
    /** @var ObjectManager */
    protected $manager;
    /** @var ObjectRepository */
    protected $repository;
    /** @var string */
    protected $entityClass;

    public function __construct(ManagerRegistry $registry, string $entityClass = DoctrineUser::class)
    {
        parent::__construct($registry, $entityClass);
    }

    public function byEmail(string $email): ?User
    {
        return $this->repository()->findOneBy(['email' => trim($email)]);
    }
}
