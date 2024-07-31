<?php


namespace App\DataFixtures;

use App\Entity\Cour;
use App\Entity\User;
use App\Entity\Zone;
use App\Entity\Notification;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CoursFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 3; $i++) {
            $cour = new Cour();
            $cour->setTitle('Title' . $i)
                 ->setDescription('Description' . $i)
                 ->setDuration(120 + $i * 30)
                 ->setDisponible(true)
                 ->setNombrePlaceDisponible(10 + $i)
                 ->setCalendrier(new \DateTime('2024-01-01 10:00:00'));

            $cour->setUser($this->getReference('user_' . $i));
            $cour->setZone($this->getReference('zone_' . $i));
            $cour->setNotifcation($this->getReference('notification_' . $i));

            $manager->persist($cour);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            ZoneFixtures::class,
            NotificationFixtures::class,
        ];
    }
}