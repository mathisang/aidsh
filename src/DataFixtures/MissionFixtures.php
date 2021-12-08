<?php

namespace App\DataFixtures;

use App\Entity\Mission;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class MissionFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $users = $this->userRepository->findAll();
        $priorityList = ['Low', 'Medium', 'High'];
        $statusList = ['To validate', 'To do', 'In progress', 'Done'];

        $faker = Faker\Factory::create('en_US');

        // Generate missions
        echo "---- Generating missions ----", PHP_EOL, PHP_EOL;
        for ($m = 1; $m < 6; $m++) {
            $nameMission = $faker->city;

            $mission = new Mission();
            echo "Creating mission : " . $nameMission, PHP_EOL;

            $mission->setName($nameMission)
                ->setDescription($faker->address)
                ->setClient($users[$m])
                ->setDateRealisation($faker->dateTimeBetween('+5 days', '+40 days'))
                ->setDateStart($faker->dateTimeBetween('-5 days', '+5 days'))
                ->setPriority($priorityList[rand(0, 2)])
                ->setStatus($statusList[rand(0, 3)]);

            $manager->persist($mission);

            echo "Mission created", PHP_EOL, PHP_EOL;
        }

        $manager->flush();
        echo "---- Missions created ----", PHP_EOL, PHP_EOL;
    }

    public function getDependencies()
    {
        return [
            ClientFixtures::class
        ];
    }
}
