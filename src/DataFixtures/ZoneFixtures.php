<?php

namespace App\DataFixtures;

use App\Entity\Zone;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ZoneFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $zone = new Zone();
            $zone->setName('Zone ' . $i)
                 ->setDescription('Description for zone ' . $i)
                 ->setLocation('Location ' . $i);
    
            // Récupérer l'utilisateur créé dans UserFixtures
            $user = $this->getReference('user_' . $i);
    
            // Associez l'utilisateur à la zone
            $zone->setUser($user);
    
            $manager->persist($zone);
    
            // Ajoutez une référence pour réutiliser la zone dans d'autres fixtures
            $this->addReference('zone_' . $i, $zone);
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