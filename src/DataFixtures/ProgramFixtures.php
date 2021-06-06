<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 4; $i++) {
            $program = new Program();
            $program->setTitle('title' .$i);
            $program->setSummary('Summary' .$i);
            $program->setPoster('Poster' .$i);

            $manager->persist($program);
        }

        $manager->flush();
    }
}
