<?php

namespace Study\Common\Domain\Repository\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class AbstractDoctrineRepository
{
    /** @var ManagerRegistry */
    protected $registry;
    /** @var EntityManagerInterface */
    protected $manager;
    /** @var EntityRepository */
    protected $repository;
    /** @var string */
    protected $entityClass;

    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        $this->registry = $registry;
        $this->entityClass = $entityClass;
    }

    protected function manager(): EntityManagerInterface
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

        if (!$manager instanceof EntityManagerInterface) {
            throw new \LogicException(sprintf(
                'The found manager for class "%s" is not of type "%s" as expected',
                $this->entityClass,
                EntityManagerInterface::class
            ));
        }

        $this->manager = $manager;

        return $this->manager;
    }

    protected function repository(): EntityRepository
    {
        if ($this->repository) {
            return $this->repository;
        }

        $this->repository = $this->manager()->getRepository($this->entityClass);

        return $this->repository;
    }

}