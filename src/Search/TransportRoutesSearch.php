<?php
namespace App\Search;

use App\Entity\Airport;
use App\Entity\RouteSchedule;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class TransportRoutesSearch
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function search(array $data): array
    {
        $departureAirportName = $data['departureAirport'];
        $arrivalAirportName = $data['arrivalAirport'];
        $departureDateTime = new DateTime($data['departureDate']) ?? null;

        if(!$departureDateTime) {
            return ['error' => sprintf('Invalid date format')];
        }
        $airportRepository = $this->entityManager->getRepository(Airport::class);
        $departureAirport = $airportRepository->findOneBy(['name' => $departureAirportName]);

        if(!$departureAirport) {
            return ['error' => sprintf('Airport with name = %s not found', $departureAirportName)];
        }
        $arrivalAirport = $airportRepository->findOneBy(['name' => $arrivalAirportName]);

        if(!$arrivalAirport) {
            return ['error' => sprintf('Airport with name = %s not found', $arrivalAirportName)];
        }

        $results = $this->entityManager->getRepository(RouteSchedule::class)
            ->findByAirportsAndDepartureDate($departureAirport, $arrivalAirport, $departureDateTime);

        if(!$results) {
            return ['error' => sprintf('No results found for this date')];
        }

        return ['searchResults' => $results];
    }
}