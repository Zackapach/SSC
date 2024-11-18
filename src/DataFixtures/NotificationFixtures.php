<?php

namespace App\DataFixtures;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NotificationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $notification = new Notification();
            $notification->setMessage('Message ' . $i)
                         ->setReadStatus(false)
                         ->setCreatedAt(new \DateTimeImmutable('2024-01-01 10:00:00'))
                         ->setUser($this->getReference('user_' . $i));

            $manager->persist($notification);

            // Ajoutez une référence pour pouvoir la récupérer dans CoursFixtures
            $this->addReference('notification_' . $i, $notification);
        }

        $manager->flush();
    }
}

