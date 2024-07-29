<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\UserProfil;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserProfilFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 3; $i++) {
            # code...
                $userProfil = new UserProfil();
                $userProfil
                ->setFirstName('First' . $i)
                ->setLastName('Last' . $i)
                ->setPhone('0123456789' . $i)
                ->setAdress('Adress' . $i)
                ->setDateOfBirth(new \DateTime('2024-01-01'))
                ->setBio('Bio for user' . $i)
                ->setUser($this->getReference('user_' . $i));
                ;

                $manager->persist($userProfil);
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            UserFixture::class,
        ];
    }
}
