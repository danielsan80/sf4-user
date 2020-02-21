<?php

namespace App\DataFixtures;

use App\User\NullUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Study\User\Domain\Model\Infrastructure\Doctrine\DoctrineUser;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new DoctrineUser(Uuid::uuid4(), 'mario@example.com', $this->encodePassword('password'));
        $manager->persist($user);
        $manager->flush();
    }

    protected function encodePassword(string $plainPassword)
    {
        return $this->passwordEncoder->encodePassword(new NullUser(), $plainPassword);
    }
}
