<?php

namespace Study\Credential\Domain\Repository\Infrastructure\Doctrine;

use Doctrine\Persistence\ManagerRegistry;
use Study\Credential\Domain\Model\Credential;
use Study\Credential\Domain\Model\Infrastructure\Doctrine\DoctrineCredential;
use Study\Credential\Domain\Repository\CredentialRepository;
use Study\Common\Domain\Repository\Infrastructure\Doctrine\AbstractDoctrineRepository;

class DoctrineCredentialRepository extends AbstractDoctrineRepository implements CredentialRepository
{

    public function __construct(ManagerRegistry $registry, string $entityClass = DoctrineCredential::class)
    {
        parent::__construct($registry, $entityClass);
    }

    public function byId(string $id): ?Credential
    {
        return $this->repository()->find($id);
    }

    public function byKey(string $key): ?Credential
    {
        return $this->repository()->findOneBy(['key' => trim($key)]);
    }
}
