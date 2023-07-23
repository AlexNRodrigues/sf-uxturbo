<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Posts;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('pt_BR');
    }

    public function load(ObjectManager $manager): void
    {

        // Status -> spam | trash | new
        for ($i=0; $i < 30; $i++) {

            $contact = new Contact();
            $contact->setName($this->faker->name())
                ->setEmail($this->faker->email())
                ->setMessage($this->faker->text())
                ->setStatus('new')
                ->setStar(0);

            $manager->persist($contact);
        }

        // Status -> draft | published | new
        $admin = new User();
        $admin->setEmail('admin@admin.sf')
            ->setRoles(['ROLE_ADMIN','ROLE_AUTHOR','ROLE_USER'])
            ->setPlainPassword('password');

        $manager->persist($admin);

        for ($i=0; $i < 12; $i++) {

            $title = $this->faker->sentence();
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($title);

            $post = new Posts();

            $post->setTitle($title)
                ->setSlug($slug)
                ->setText($this->faker->paragraph(5))
                ->setStatus('draft')
                ->setLikes(rand(0, 9999))
                ->setDislike(rand(0,9999))
                ->setViews(rand(0, 99999))
                ->setAuthor($admin)
                ->setPublicationAt(new \DateTimeImmutable())
                ;

            $manager->persist($post);
        }
        $manager->flush();
    }
}
