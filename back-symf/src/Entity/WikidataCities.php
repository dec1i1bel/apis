<?php

namespace App\Entity;

use App\Repository\WikidataCitiesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WikidataCitiesRepository::class)
 */
class WikidataCities
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $wikidata_id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $city_name_en;

    /**
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     */
    private $longitude;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWikidataId(): ?string
    {
        return $this->wikidata_id;
    }

    public function setWikidataId(string $wikidata_id): self
    {
        $this->wikidata_id = $wikidata_id;

        return $this;
    }

    public function getCityNameEn(): ?string
    {
        return $this->city_name_en;
    }

    public function setCityNameEn(string $city_name_en): self
    {
        $this->city_name_en = $city_name_en;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }
}
