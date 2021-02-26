<?php

namespace App\Repository;

use App\Entity\Airport;
use App\Entity\RouteSchedule;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RouteSchedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method RouteSchedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method RouteSchedule[]    findAll()
 * @method RouteSchedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RouteScheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RouteSchedule::class);
    }

    public function findByAirportsAndDepartureDate(Airport $departureAirport, Airport $arrivalAirport, DateTimeInterface $departureDateTime): array
    {
        $trips = $this->createQueryBuilder('routeSchedule')
            ->join('routeSchedule.transportRoute', 'transportRoute')
            ->where('transportRoute.departureAirport = :departureAirport')
            ->andWhere('transportRoute.arrivalAirport = :arrivalAirport')
            ->andWhere('DATE(routeSchedule.departureDateTime) = :departureDateTime')
            ->setParameters([
                'departureAirport' => $departureAirport,
                'arrivalAirport' => $arrivalAirport,
                'departureDateTime' => $departureDateTime
            ])
            ->getQuery()
            ->getResult();
        $results = [];

        /** @var RouteSchedule $trip */
        foreach ($trips as $trip) {
            $results[] = [
                'transporter' => [
                    'code' => $trip->getTransportRoute()->getTransporter()->getCode(),
                    'name' => $trip->getTransportRoute()->getTransporter()->getName(),
                ],
                'flightNumber' => $trip->getTransportRoute()->getName(),
                'departureAirport' => $trip->getTransportRoute()->getDepartureAirport()->getName(),
                'arrivalAirport' => $trip->getTransportRoute()->getArrivalAirport()->getName(),
                'departureDateTime' => $trip->getDepartureDateTime()->setTimezone(
                    new DateTimeZone($trip->getTransportRoute()->getDepartureAirport()->getTimezone())
                )->format('Y-m-d H:i'),
                'arrivalDateTime' => $trip->getArrivalDateTime()->setTimezone(
                    new DateTimeZone($trip->getTransportRoute()->getArrivalAirport()->getTimezone())
                )->format('Y-m-d H:i'),
                'duration' => $trip->getTransportRoute()->getDuration(),
            ];
        }

        return $results;
    }
}
