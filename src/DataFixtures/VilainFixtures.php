<?php

namespace App\DataFixtures;

use App\Entity\Vilain;
use App\Repository\MissionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VilainFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(MissionRepository $missionsRepository)
    {
        $this->missionsRepository = $missionsRepository;
    }
    
    function removeSpace($name)
    {
        return preg_replace('/\s+/', '', $name);
    }

    public function load(ObjectManager $manager): void
    {
        $missions = $this->missionsRepository->findAll();

        $lastIdVilain = 1;

        echo "---- Generating Vilains ----", PHP_EOL, PHP_EOL;
        // Generate vilains
        for ($v = 1; $v < 51; $v++) {
            echo "Generating vilain", PHP_EOL;

            $dataVilain = file_get_contents('https://superheroapi.com/api/2451699171629706/' . $lastIdVilain);
            $dataVilainXDecoded = json_decode($dataVilain);

            while ($dataVilainXDecoded->biography->alignment !== "bad") {
                echo "I'm good :( Regenerating vilain", PHP_EOL;
                $lastIdVilain++;

                $dataVilain = file_get_contents('https://superheroapi.com/api/2451699171629706/' . $lastIdVilain);
                $dataVilainXDecoded = json_decode($dataVilain);
            }
            $lastIdVilain++;

            $vilain = new Vilain();
            echo "Creating vilain : " . $dataVilainXDecoded->name.$v, PHP_EOL;

            $vilain->setName($this->removeSpace($dataVilainXDecoded->name).$v)
                ->setPublisher($dataVilainXDecoded->biography->publisher)
                ->setImage($dataVilainXDecoded->image->url);
            if($v < 35) {
                $vilain->addMissionsVilain($missions[rand(0, count($missions)-1)]);
            }

            $manager->persist($vilain);
            echo "Vilain created", PHP_EOL, PHP_EOL;
        }
        echo "---- Vilains created ----", PHP_EOL, PHP_EOL;

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            MissionFixtures::class
        ];
    }
}
