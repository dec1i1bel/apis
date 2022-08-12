<?php

namespace App\Command;

use App\Entity\CityPlaces;
use App\Entity\WikidataCities;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetCitiesPlacesCommand extends Command
{
    protected static $defaultName = 'cities:places';

    private $client;
    private $doctrine;

    public function __construct(HttpClientInterface $client, ManagerRegistry $doctrine)
    {
        $this->client = $client;
        $this->doctrine = $doctrine;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = $this->client;
        $doctrine = $this->doctrine;

        try {
            $dbCities = $doctrine->getRepository(WikidataCities::class)->findAll();
            $dbPlaces = $doctrine->getRepository(CityPlaces::class)->findAll();

            if (!$dbCities || !$dbPlaces) {
                throw new \Exception('error receiving cities or places from database');
            }
        } catch (\Exception $e) {
            $output->writeln([
                'error: '.$e->getMessage(),
                'statusCode: '.$e->getCode(),
            ]);

            return Command::FAILURE;
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

                $response = $client->request($method, $url, $options);
                $statusCode = $response->getStatusCode();

                if ($statusCode != 200) {
                    throw new \Exception('error in request city places from 3rd-party api. Code: '.$statusCode);
                }

                $output->writeln([
                    'got city <'.$cityName.'> places from external api'
                ]);

                $content = $response->toArray();
                $places = $content['data']['getPlaces'];

            } catch (\Exception $e) {
                $output->writeln([
                    'error: '.$e->getMessage(),
                    'statusCode: '.$e->getCode(),
                ]);
                return Command::FAILURE;
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

                    $output->writeln([
                        'place <'.$place['name'].'> saved',
                    ]);
                }
            }
        }
        return Command::SUCCESS;
    }
}