<?php

namespace App\DataFixtures;

use App\Entity\Airport;
use App\Entity\RouteSchedule;
use App\Entity\Transporter;
use App\Entity\TransportRoute;
use App\Entity\User;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setEmail('test@gmail.com')
            ->setPassword('5555')
            ->setRoles([])
            ->setApiToken('55555');

        $manager->persist($user);

        $faker = Factory::create();
        $airports = [];

        for ($i = 0; $i < 10; $i++) {
            $airport = new Airport();

            $airport
                ->setName($faker->company)
                ->setCountry($faker->country)
                ->setCity($faker->city)
                ->setTimezone($faker->timezone);

            $manager->persist($airport);
            $airports[] = $airport;
        }

        $transporters = [];

        for ($i = 0; $i < 2; $i++) {
            $transporter = new Transporter();

            $transporter
                ->setName($faker->company)
                ->setCode($faker->countryCode);

            $manager->persist($transporter);
            $transporters[] = $transporter;
        }

        $transportRoutes = [];

        for ($i = 0; $i < 10; $i++) {
            $transportRoute = new TransportRoute();

            $transportRoute
                ->setName($faker->postcode)
                ->setTransporter($transporters[rand(0,1)])
                ->setDepartureAirport($airports[rand(0, 4)])
                ->setArrivalAirport($airports[rand(5,9)])
                ->setDuration(rand(60, 180));

            $manager->persist($transportRoute);
            $transportRoutes[] = $transportRoute;
        }

        for ($i = 0; $i < 1000; $i++) {
            $routeSchedule = new RouteSchedule();

            /** @var TransportRoute $transportRoute */
            $transportRoute = $transportRoutes[rand(0,9)];
            $departureDateTime = $faker->dateTimeThisYear('now');
            $departureDateTimeUtc = (clone $departureDateTime)->getTimestamp();
            $arriveTimeUtc = $departureDateTimeUtc + (60 * $transportRoute->getDuration());
            $arriveTime = (new DateTime())->setTimestamp($arriveTimeUtc);
            $routeSchedule
                ->setTransportRoute($transportRoute)
                ->setDepartureDateTime($departureDateTime)
                ->setArrivalDateTime($arriveTime);

            $manager->persist($routeSchedule);
        }


        $manager->flush();
    }
}
