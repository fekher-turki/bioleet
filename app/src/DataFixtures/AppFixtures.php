<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use DateTimeImmutable;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


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
        $languages = ['ar', 'en', 'fr', 'de', 'it'];
        $countries = ['TN', 'DZ', 'MA', 'PS', 'FR'];

        
        // Users
        $users = [];

        $admin = new User();
        $admin->setFirstName('Fekher')
            ->setLastName('Turki')
            ->setUsername('TF2wo')
            ->setEmail('turki.fekher@gmail.com')
            ->setPlainPassword('passpass')
            ->setGender('male')
            ->setBirthday(DateTimeImmutable::createFromFormat('m-d-Y', '05-23-1994'))
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setCountry('TN')
            ->setLanguages(['ar', 'en', 'fr']);

        $admin->setNickname($admin->getUsername());

        $users[] = $admin;
        $manager->persist($admin);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstName($this->faker->firstName())
                ->setLastName($this->faker->lastName())
                ->setUsername($this->faker->firstName() . $this->faker->lastName())
                ->setEmail($this->faker->email())
                ->setPlainPassword('password')
                ->setGender(mt_rand(0, 1) == 1 ? "male" : "female")
                ->setBirthday($this->faker->dateTimeBetween("-{$maxAge} years", "-{$minAge} years"))
                ->setRoles(['ROLE_USER']);

            $randomCountry = array_rand($countries);
            $randomLanguage = array_rand($languages, 2);
            $user->setNickname($user->getUsername())
                ->setCountry($countries[$randomCountry])
                ->setLanguages([$languages[$randomLanguage[0]], $languages[$randomLanguage[1]]]);

            $users[] = $user;
            $manager->persist($user);
        }

        $manager->flush();
    }
}
