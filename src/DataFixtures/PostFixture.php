<?php

namespace App\DataFixtures;

use App\Entity\Posts;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 30; $i++) {
            $post = new Posts();
            $post
                ->setTitle("titre de l'annonce" . $i)
                ->setDescription("description de l'annonce à publier, un simple texte de quelques lignes pour voir si tout passe correctement, et aussi voir si possible de faire une pagination correcte")
                ->setZipCode("38000")
                ->setCity("Grenoble");
            $manager->persist($post);
        }

        $manager->flush();
    }
}
