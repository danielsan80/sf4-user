<?php

namespace Study\Common\Domain\Repository\Infrastructure\Doctrine;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

abstract class AbstractDoctrineRepository
{
    /** @var ManagerRegistry */
    protected $registry;
    /** @var ObjectManager */
    protected $manager;
    /** @var ObjectRepository */
    protected $repository;
    /** @var string */
    protected $entityClass;

    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        $this->registry = $registry;
        $this->entityClass = $entityClass;
    }

    protected function manager(): ObjectManager
    {
        if ($this->manager) {
            return $this->manager;
        }

        $manager = $this->registry->getManagerForClass($this->entityClass);

        if ($manager === null) {
            throw new \LogicException(sprintf(
                'Could not find the entity manager for class "%s". Check your Doctrine configuration to make sure it is configured to load this entity’s metadata.',
                $this->entityClass
            ));
        }

        $this->manager = $manager;

        return $this->manager;
    }

    protected function repository(): ObjectRepository
    {
        if ($this->repository) {
            return $this->repository;
        }

        $this->repository = $this->manager()->getRepository($this->entityClass);

        return $this->repository;
    }

}