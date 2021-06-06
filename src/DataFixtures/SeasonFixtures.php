<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 4; $i++) {
            $season = new Season();
            $season->setNumber(mt_rand(1, 10));
            $season->setYear(mt_rand(1995, 2021));
            $season->setDescription('description' .$i);

            $manager->persist($season);
        }

        $manager->flush();
    }
}
