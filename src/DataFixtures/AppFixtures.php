<?php

namespace App\DataFixtures;

use App\Entity\Mission;
use App\Entity\User;
use App\Entity\Vilain;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class AppFixtures extends Fixture
{
//    /**
//     * Encoder de mot de passe
//     * @var UserPasswordHasherInterface
//     */
//    private $encoder;
//
//    public function __construct(UserPasswordHasherInterface $encoder)
//    {
//        $this->encoder = $encoder;
//    }
//
//    function removeSpace($name)
//    {
//        return preg_replace('/\s+/', '', $name);
//    }

    public function load(ObjectManager $manager): void
    {
//        $faker = Faker\Factory::create('fr_FR');
//
//        for ($sh = 1; $sh < 2; $sh++) {
//            $nameMission = $faker->title;
//
//            $mission = new Mission();
//            echo "Creating mission : " . $nameMission, PHP_EOL;
//
//            $mission->setName('test')
//                ->setDescription('teqglergkrng')
//                ->setClient($client)
//                ->setDateRealisation()
//                ->setDateStart()
//                ->setPriority()
//                ->setPriority()
//                ->setStatus();
//
//            $manager->persist($mission);
//
//            echo "Mission created", PHP_EOL, PHP_EOL;
//        }
//
//        // Professor X
//        $professorX = file_get_contents('https://superheroapi.com/api/2451699171629706/527');
//        $professorXDecoded = json_decode($professorX);
//
//        echo "Generating Professor X", PHP_EOL;
//
//        $superAdmin = new User();
//        echo "Creating Professor X", PHP_EOL;
//        $hashPassword = $this->encoder->hashPassword($superAdmin, "password");
//        $superAdmin->setUsername($this->removeSpace($professorXDecoded->name))
//            ->setRoles(['ROLE_ADMIN'])
//            ->setPassword($hashPassword)
//            ->setPublisher($professorXDecoded->biography->publisher)
//            ->setImage($professorXDecoded->image->url);
//
//        $manager->persist($superAdmin);
//
//        echo "Professor X created", PHP_EOL, PHP_EOL;
//
//        $lastIdHero = 1;
//
//        // Generate superheros
//
//        echo "Generating Super Heros", PHP_EOL, PHP_EOL;
//        for ($sh = 1; $sh < 26; $sh++) {
//            echo "Generating hero", PHP_EOL;
//
//            $dataHero = file_get_contents('https://superheroapi.com/api/2451699171629706/' . $lastIdHero);
//            $dataHeroXDecoded = json_decode($dataHero);
//
//            while ($dataHeroXDecoded->biography->alignment !== "good") {
//                echo "I'm bad :( Regenerating hero", PHP_EOL;
//                $lastIdHero++;
//
//                $dataHero = file_get_contents('https://superheroapi.com/api/2451699171629706/' . $lastIdHero);
//                $dataHeroXDecoded = json_decode($dataHero);
//            }
//            $lastIdHero++;
//
//            $superHero = new User();
//            echo "Creating hero : " . $dataHeroXDecoded->name.$sh, PHP_EOL;
//
//            $hashPassword = $this->encoder->hashPassword($superHero, "password");
//            $superHero->setUsername($this->removeSpace($dataHeroXDecoded->name).$sh)
//                ->setRoles(['ROLE_SUPER_HERO'])
//                ->setPassword($hashPassword)
//                ->setPublisher($dataHeroXDecoded->biography->publisher)
//                ->setImage($dataHeroXDecoded->image->url);
//
//            $manager->persist($superHero);
//
//            echo "Hero created", PHP_EOL, PHP_EOL;
//        }
//
//        echo "Super heros created", PHP_EOL, PHP_EOL;
//
//        $lastIdVilain = 1;
//
//        echo "Generating Vilains", PHP_EOL, PHP_EOL;
//        // Generate vilains
//        for ($sh = 1; $sh < 51; $sh++) {
//            echo "Generating vilain", PHP_EOL;
//
//            $dataVilain = file_get_contents('https://superheroapi.com/api/2451699171629706/' . $lastIdVilain);
//            $dataVilainXDecoded = json_decode($dataVilain);
//
//            while ($dataVilainXDecoded->biography->alignment !== "bad") {
//                echo "I'm good :( Regenerating vilain", PHP_EOL;
//                $lastIdVilain++;
//
//                $dataVilain = file_get_contents('https://superheroapi.com/api/2451699171629706/' . $lastIdVilain);
//                $dataVilainXDecoded = json_decode($dataVilain);
//            }
//            $lastIdVilain++;
//
//            $vilain = new Vilain();
//            echo "Creating vilain : " . $dataVilainXDecoded->name.$sh, PHP_EOL;
//
//            $vilain->setName($this->removeSpace($dataVilainXDecoded->name).$sh)
//                ->setPublisher($dataVilainXDecoded->biography->publisher)
//                ->setImage($dataVilainXDecoded->image->url);
//
//            $manager->persist($vilain);
//            echo "Vilain created", PHP_EOL, PHP_EOL;
//        }
//        echo "Vilains created", PHP_EOL, PHP_EOL;
//
//        $manager->flush();
    }
}
