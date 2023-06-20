<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('en_EN');
    }
    
    public function load(ObjectManager $manager): void
    {
        $minAge = 16;
        $maxAge = 50;
        // Users
        $users = [];
        
        for ($i = 0; $i < 10; $i++) { 
            $user = new User();
            $user->setFirstName($this->faker->firstName())
                ->setLastName($this->faker->lastName())
                ->setUsername($this->faker->firstName() . $this->faker->lastName())
                ->setEmail($this->faker->email())
                ->setPlainPassword('password')
                ->setGender(mt_rand(0, 1) == 1 ? "Male" : "Female")
                ->setBirthday($this->faker->dateTimeBetween("-{$maxAge} years", "-{$minAge} years"))
                ->setRoles(['ROLE_USER']);

            $user->setNickname($user->getUsername());

            $users[] = $user;
            $manager->persist($user);
        }

        $manager->flush();
    }
}
