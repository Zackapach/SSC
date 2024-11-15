<?php


namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture implements DependentFixtureInterface
{
    private $existingDates = [];

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $course = new Course();
            $course->setTitle('Title' . $i)
                 ->setDescription('Description' . $i)
                 ->setDuration(3600 / 60)
                 ->setAvailablePlaces(10 + $i)
                 ->setStartDatetime($this->generateRandomDate());
                //  ->setstartDatetime(new \DateTime('2024-01-01 10:00:00'));
               

            $course->setCoach($this->getReference('user_' . $this->generateRandomInt(3)));
            $course->setZone($this->getReference('zone_' . $this->generateRandomInt(3)));
            $course->setNotifcation($this->getReference('notification_' . $this->generateRandomInt(3)));

            $manager->persist($course);
        }

        $manager->flush();
    }

    private function generateRandomDate(): \DateTime
    {
        // Définir le début et la fin de la semaine
        $startOfWeek = new \DateTime('monday this week');
        $endOfWeek = new \DateTime('sunday this week 23:59:59');

        do {
            // Générer un jour aléatoire dans cette semaine
            $randomTimestamp = mt_rand($startOfWeek->getTimestamp(), $endOfWeek->getTimestamp());
            $randomDate = (new \DateTime())->setTimestamp($randomTimestamp);

            // Définir une heure entre 8h et 18h pour les cours (par exemple)
            $randomHour = rand(8, 18);
            $randomMinute = rand(0, 1) * 30; // Choix entre 00 et 30 minutes
            $randomDate->setTime($randomHour, $randomMinute);

        } while ($this->dateOverlaps($randomDate));

        // Ajouter la date choisie au tableau pour éviter les chevauchements
        $this->existingDates[] = $randomDate;

        return $randomDate;
    }

    private function generateRandomInt(int $max): int
{
    return rand(0, $max - 1); // Génère un nombre aléatoire entre 0 et max - 1
}

    private function dateOverlaps(\DateTime $date): bool
    {
        foreach ($this->existingDates as $existingDate) {
            // Vérifie que l'heure ne se chevauche pas avec les cours existants
            if ($existingDate->format('Y-m-d H:i') == $date->format('Y-m-d H:i')) {
                return true;
            }
        }

        return false;
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