<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class UserFixture extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager ): void
    {
       for ($i=0; $i < 3 ; $i++) { 
        # code...
            $user = new User();
            $user
            ->setEmail('mail'. $i . '@mail.com')
            ->setPassword($this->userPasswordHasher->hashPassword(
                $user,
                'password'
            ))
            ->setIsVerified(true);

            $this->addReference('user_'. $i, $user);
            
            $manager->persist($user);
       }

        $manager->flush();
        
    }
    
}
 