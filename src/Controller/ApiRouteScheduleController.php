<?php

namespace App\Controller;

use App\Search\TransportRoutesSearch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/api/route-schedule/", name="api_route_schedule_") */
class ApiRouteScheduleController extends AbstractController
{
    private $transportRoutesSearch;

    public function __construct(TransportRoutesSearch $transportRoutesSearch)
    {
        $this->transportRoutesSearch = $transportRoutesSearch;
    }

    /** @Route("search/", name="search", methods={"POST"}) */
    public function search(Request $request): Response
    {
        $searchQuery = $request->getContent();
        $data = json_decode($searchQuery, true);
        $searchResults = $this->transportRoutesSearch->search($data);
        $result = [
            'searchQuery' => $searchQuery,
            'searchResults' => $searchResults,
        ];

        return new JsonResponse(base64_encode(json_encode($result)));
    }
}