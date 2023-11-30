<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; $i++) {
            $post = new Post();
            $post->setTitle("Post " . $i);
            $post->setImage("https://picsum.photos/200/300?random=" . $i);

            // Aggiunge un campo data con date casuali nei prossimi 50 giorni
            $randomDate = new \DateTime();
            $randomDate->modify("+" . rand(1, 50) . " days");

            $post->setDate($randomDate);

            $manager->persist($post);
        }


        $manager->flush();
    }
}
