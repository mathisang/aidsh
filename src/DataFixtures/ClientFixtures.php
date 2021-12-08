<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class ClientFixtures extends Fixture
{
    /**
     * Encoder de mot de passe
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public const CLIENT_REFERENCE = 'client';

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('en_US');

        // Generate clients
        echo "---- Generating clients ----", PHP_EOL, PHP_EOL;
        for ($c = 1; $c < 16; $c++) {
            $name = $faker->userName;

            $client = new User();
            echo "Creating client : " . $name, PHP_EOL;

            $hashPassword = $this->encoder->hashPassword($client, "password");
            $client->setUsername($name)
                ->setRoles(['ROLE_CLIENT'])
                ->setPassword($hashPassword)
                ->setPublisher("Client")
                ->setImage("https://sbcf.fr/wp-content/uploads/2018/03/sbcf-default-avatar.png");

            $manager->persist($client);

            echo "Client created", PHP_EOL, PHP_EOL;
        }

        $manager->flush();
        echo "---- Clients created ----", PHP_EOL, PHP_EOL;
    }
}
