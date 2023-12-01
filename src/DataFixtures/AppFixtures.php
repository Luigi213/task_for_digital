<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $words = ['Lorem', 'Ipsum', 'Dolor', 'Sit', 'Amet', 'Consectetur', 'Adipiscing', 'Elit'];

        for ($i = 0; $i < 50; $i++) {
            $post = new Post();

            // Genera un titolo casuale combinando alcune parole casuali
            $title = '';
            $numWords = rand(2, 5); // Numero casuale di parole nel titolo
            for ($j = 0; $j < $numWords; $j++) {
                $title .= $words[array_rand($words)] . ' ';
            }

            $post->setTitle(trim($title));

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
