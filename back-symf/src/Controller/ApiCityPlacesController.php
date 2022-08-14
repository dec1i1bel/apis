<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\CityPlaces;
use Doctrine\Persistence\ManagerRegistry;

class ApiCityPlacesController extends AbstractController
{
    /**
     * @return JsonResponse
     */
    public function getCityPlaces(ManagerRegistry $doctrine, int $cityId): JsonResponse
    {
        try {
            $cp = $doctrine->getRepository(CityPlaces::class);
            $cityPlaces = $cp->findBy(
                ['city_id' => $cityId]
            );

            foreach ($cityPlaces as $place) {
                $places[$place->getCity()->getId()][] = [

                    'id' => $place->getId(),
                    'name' => $place->getName(),
                    'latitude' => $place->getLatitude(),
                    'longitude' => $place->getLongitude(),
                    'distance' => $place->getDistance(),
                ];
            }
            if (isset($places)) {
                return $this->json($places);
            } else {
                throw new \Exception('couldn`t find city with the id, or couldn`t find places near the city');
            }
        } catch (\ Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
