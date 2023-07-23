<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class Users extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('pt_BR');
    }

    public function load(ObjectManager $manager): void
    {
        // $admin = new User();
        // $admin->setEmail('admin@admin.sf')
        //     ->setRoles(['ROLE_ADMIN','ROLE_AUTHOR','ROLE_USER'])
        //     ->setPlainPassword('password');

        // $manager->persist($admin);

        for ($i=0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');

            $users[] = $user;
            $manager->persist($user);
        }
        $manager->flush();
    }
}
