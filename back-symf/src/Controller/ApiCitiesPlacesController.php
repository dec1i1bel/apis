<?php

namespace App\Controller;

use App\Entity\WikidataCities;
use App\Entity\CityPlaces;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiCitiesPlacesController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    
    public function test(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiCitiesPlacesController.php',
        ]);
    }

    /**
     * @param ManagerRegistry $doctrine
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function saveCitiesPlacesToDB(ManagerRegistry $doctrine): Response
    {
        try {
            $dbCities = $doctrine->getRepository(WikidataCities::class)->findAll();
            $dbPlaces = $doctrine->getRepository(CityPlaces::class)->findAll();
            
            if (!$dbCities || !$dbPlaces) {
                throw new \Exception('error recieving cities or places from database');
            }
        } catch (\Exception $e) {
            return  $this->json([
                'error' => $e->getMessage()
            ]);
        }

        $entityManager = $doctrine->getManager();

        foreach ($dbCities as $city) {
            try {
                $id = $city->getId();
                $cityName = $city->getCityNameEn();
                $lat = $city->getLatitude();
                $lng = $city->getLongitude();

                $method = 'POST';
                $url = 'https://travel-places.p.rapidapi.com/';
                $options = [
                    'headers' => [
                        'content-type' => 'application/json',
                        'X-RapidAPI-Key' => '371ef07306msh4c6de730e39801dp1616ccjsn600fb9f97d16',
                        'X-RapidAPI-Host' => 'travel-places.p.rapidapi.com',
                    ],
                    'body' => '{"query":"{ getPlaces(lat:'.$lat.',lng:'.$lng.',maxDistMeters:200000) { name,lat,lng,abstract,distance } }"}',
                ];
    
                $response = $this->client->request($method, $url, $options);
                $statusCode = $response->getStatusCode();

                if ($statusCode != 200) {
                    throw new \Exception('error in request city places from 3rd-party api. Code: '.$statusCode);
                }

                $content = $response->toArray();
                $places = $content['data']['getPlaces'];

            } catch (\Exception $e) {
                return $this->json([
                    'error' => $e->getMessage()
                ]);
            }
            
            foreach ($places as $place) {
                $isDublicate = false;

                foreach ($dbPlaces as $dbPlace) {
                    if ($dbPlace->getName() == $place['name']) {
                        $isDublicate = true;
                    }
                }

                if (!$isDublicate && $place['name'] != $cityName) {
                    $cp = new CityPlaces();
                    $cp->setName($place['name']);
                    $cp->setLatitude($place['lat']);
                    $cp->setLongitude($place['lng']);
                    $cp->setCityId($city);
                    $cp->setDistance($place['distance']);

                    $entityManager->persist($cp);
                    $entityManager->flush();
                }
            }
        }

        return $this->json([
            'saveCitiesPlacestoDB' => 'done'
        ]);
    }
}
