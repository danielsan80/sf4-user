<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Study\Credential\Domain\Model\Infrastructure\Doctrine\DoctrineCredential;
use Study\Credential\Domain\Model\KeyGenerator;

class CredentialFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $keyGenerator = new KeyGenerator();

        $credential = new DoctrineCredential(Uuid::uuid4(), 'Acme', $keyGenerator->generate('a_seed'));
        $manager->persist($credential);
        $manager->flush();
    }

}
