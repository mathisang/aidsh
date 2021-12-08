<?php
//
//namespace App\DataFixtures;
//
//use App\Entity\User;
//use App\Entity\Vilain;
//use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Persistence\ObjectManager;
//use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
//use Faker;
//
//class AppFixtures extends Fixture
//{
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
//
//    public function load(ObjectManager $manager): void
//    {
//        $faker = Faker\Factory::create('fr_FR');
//
//        // IDs list superhero
//        $superHeroArray = [];
//        $idHeroArray = [];
//
//        for ($i = 0; $i < 26; $i++) {
//            $randomNumber = rand(1, 526);
//
//            while (in_array($randomNumber, $idHeroArray)) {
//                $randomNumber = rand(1, 526);
//            }
//
//            $dataHero = file_get_contents('https://superheroapi.com/api/2451699171629706/' . $randomNumber);
//            $dataHeroXDecoded = json_decode($dataHero);
//
//            while ($dataHeroXDecoded->biography->alignment !== "good") {
//                $randomNumber = rand(1, 526);
//
//                $dataHero = file_get_contents('https://superheroapi.com/api/2451699171629706/' . $randomNumber);
//                $dataHeroXDecoded = json_decode($dataHero);
//            }
//
//            array_push($superHeroArray, $dataHeroXDecoded);
//            array_push($idHeroArray, $randomNumber);
//        }
//
//        // IDs list vilains
//        $vilainArray = [];
//        $idVilainArray = [];
//
//        for ($i = 528; $i < 731; $i++) {
//            $dataVilain = file_get_contents('https://superheroapi.com/api/2451699171629706/' . $i);
//            $dataVilainXDecoded = json_decode($dataVilain);
//
//            while ($dataVilainXDecoded->biography->alignment !== "bad") {
//                $randomNumber = rand(1, 526);
//
//                $dataVilain = file_get_contents('https://superheroapi.com/api/2451699171629706/' . $i);
//                $dataVilainXDecoded = json_decode($dataVilain);
//            }
//
//            array_push($vilainArray, $dataVilainXDecoded);
//            array_push($idVilainArray, $randomNumber);
//        }
//
//        // Professor X
//        $professorX = file_get_contents('https://superheroapi.com/api/2451699171629706/527');
//        $professorXDecoded = json_decode($professorX);
//
//        $superAdmin = new User();
//        $hashPassword = $this->encoder->hashPassword($superAdmin, "password");
//        $superAdmin->setUsername($this->removeSpace($professorXDecoded->name))
//            ->setRoles(['ROLE_ADMIN'])
//            ->setPassword($hashPassword)
//            ->setPublisher($professorXDecoded->biography->publisher)
//            ->setImage($professorXDecoded->image->url);
//
//        $manager->persist($superAdmin);
//
//        // Generate superheros
//        for ($sh = 0; $sh < count($superHeroArray); $sh++) {
//            $superHero = new User();
//
//            $hashPassword = $this->encoder->hashPassword($superHero, "password");
//            $superHero->setUsername($this->removeSpace($superHeroArray[$sh]->name))
//                ->setRoles(['ROLE_SUPER_HERO'])
//                ->setPassword($hashPassword)
//                ->setPublisher($superHeroArray[$sh]->biography->publisher)
//                ->setImage($superHeroArray[$sh]->image->url);
//
//            $manager->persist($superHero);
//        }
//
//        // Generate clients
//        for ($c = 0; $c < 16; $c++) {
//            $client = new User();
//
//            $hashPassword = $this->encoder->hashPassword($client, "password");
//            $client->setUsername($faker->userName)
//                ->setRoles(['ROLE_CLIENT'])
//                ->setPassword($hashPassword)
//                ->setPublisher("Client")
//                ->setImage("https://sbcf.fr/wp-content/uploads/2018/03/sbcf-default-avatar.png");
//
//            $manager->persist($client);
//        }
//
//        // Generate vilains
//        for ($sh = 0; $sh < count($vilainArray); $sh++) {
//            $vilain = new Vilain();
//
//            $vilain->setName($this->removeSpace($dataHeroXDecoded->name))
//                ->setPublisher($dataHeroXDecoded->biography->publisher)
//                ->setImage($dataHeroXDecoded->image->url);
//
//            $manager->persist($vilain);
//        }
//
//        $manager->flush();
//    }
//}
