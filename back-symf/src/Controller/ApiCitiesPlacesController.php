<?php

namespace App\Controller;

use App\Entity\WikidataCities;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiCitiesPlacesController extends AbstractController
{
    public function test(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiCitiesPlacesController.php',
        ]);
    }

    /**
     * + получаем координаты городов из wikidata_cities,
     * > по ним получаем названия и координаты мест из Rapidapi Travel API
     * - данные мест сохраняем в city_places
     */
    public function saveCitiesPlacestoDB(ManagerRegistry $doctrine): Response
    {
        $dbCities = $doctrine->getRepository(WikidataCities::class)->findAll();

        if (!$dbCities) {
            throw $this->createNotFoundException(
                'error in quering WikidataCitiesRepository'
            );
        }

        foreach ($dbCities as $city) {
            // получаем данные по местам города из Travel API. используем http-клиент Symfony https://symfony.com/doc/5.4/http_client.html
            
            // сохраняем их в city_places. https://symfony.com/doc/5.4/doctrine.html#persisting-objects-to-the-database
        }
        

        return $this->json([
            'saveCitiesPlacestoDB' => 'done'
        ]);
    }
}
