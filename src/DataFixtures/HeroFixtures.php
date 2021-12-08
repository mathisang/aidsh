<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Vilain;
use App\Repository\MissionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HeroFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * Encoder de mot de passe
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder, MissionRepository $missionsRepository)
    {
        $this->encoder = $encoder;
        $this->missionsRepository = $missionsRepository;
    }

    function removeSpace($name)
    {
        return preg_replace('/\s+/', '', $name);
    }

    public function load(ObjectManager $manager): void
    {
        $missions = $this->missionsRepository->findAll();

        // Professor X
        $professorX = file_get_contents('https://superheroapi.com/api/2451699171629706/527');
        $professorXDecoded = json_decode($professorX);

        echo "---- Generating Professor X ----", PHP_EOL;

        $superAdmin = new User();
        echo "Creating Professor X", PHP_EOL;
        $hashPassword = $this->encoder->hashPassword($superAdmin, "password");
        $superAdmin->setUsername($this->removeSpace($professorXDecoded->name))
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($hashPassword)
            ->setPublisher($professorXDecoded->biography->publisher)
            ->setImage($professorXDecoded->image->url);

        $manager->persist($superAdmin);

        echo "---- Professor X created ----", PHP_EOL, PHP_EOL;

        $lastIdHero = 1;

        // Generate superheros

        echo "---- Generating Super Heros ----", PHP_EOL, PHP_EOL;
        for ($sh = 1; $sh < 26; $sh++) {
            echo "Generating hero", PHP_EOL;

            $dataHero = file_get_contents('https://superheroapi.com/api/2451699171629706/' . $lastIdHero);
            $dataHeroXDecoded = json_decode($dataHero);

            while ($dataHeroXDecoded->biography->alignment !== "good") {
                echo "I'm bad :( Regenerating hero", PHP_EOL;
                $lastIdHero++;

                $dataHero = file_get_contents('https://superheroapi.com/api/2451699171629706/' . $lastIdHero);
                $dataHeroXDecoded = json_decode($dataHero);
            }
            $lastIdHero++;

            $superHero = new User();
            echo "Creating hero : " . $dataHeroXDecoded->name.$sh, PHP_EOL;

            $hashPassword = $this->encoder->hashPassword($superHero, "password");
            $superHero->setUsername($this->removeSpace($dataHeroXDecoded->name).$sh)
                ->setRoles(['ROLE_SUPER_HERO'])
                ->setPassword($hashPassword)
                ->setPublisher($dataHeroXDecoded->biography->publisher)
                ->setImage($dataHeroXDecoded->image->url);
            if($sh < 15) {
                $superHero->addMissionsHero($missions[rand(0, count($missions)-1)]);
            }

            $manager->persist($superHero);

            echo "Hero created", PHP_EOL, PHP_EOL;
        }

        echo "---- Super heros created ----", PHP_EOL, PHP_EOL;

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            MissionFixtures::class
        ];
    }
}
