<?php


namespace App\DataFixtures;


use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 4; $i++) {
            $episode = new Episode();
            $episode->setTitle('Title' .$i);
            $episode->setNumber(mt_rand(1, 10));
            $episode->setSynopsis('Synopsis' .$i);

            $manager->persist($episode);
        }

        $manager->flush();
    }
}
