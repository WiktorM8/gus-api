<?php

namespace App\Entity;

use App\Repository\RegonDataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegonDataRepository::class)]
class RegonData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 14)]
    private ?string $regon = null;

    #[ORM\Column(length: 120)]
    private ?string $nazwa = null;

    #[ORM\Column(length: 40)]
    private ?string $wojewodztwo = null;

    #[ORM\Column(length: 50)]
    private ?string $powiat = null;

    #[ORM\Column(length: 50)]
    private ?string $gmina = null;

    #[ORM\Column(length: 43)]
    private ?string $miejscowosc = null;

    #[ORM\Column(length: 6)]
    private ?string $kod_pocztowy = null;

    #[ORM\Column(length: 70)]
    private ?string $ulica = null;

    #[ORM\Column(length: 2)]
    private ?string $typ = null;

    #[ORM\Column(length: 1)]
    private ?string $silosID = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegon(): ?string
    {
        return $this->regon;
    }

    public function setRegon(string $regon): static
    {
        $this->regon = $regon;

        return $this;
    }

    public function getNazwa(): ?string
    {
        return $this->nazwa;
    }

    public function setNazwa(string $nazwa): static
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    public function getWojewodztwo(): ?string
    {
        return $this->wojewodztwo;
    }

    public function setWojewodztwo(string $wojewodztwo): static
    {
        $this->wojewodztwo = $wojewodztwo;

        return $this;
    }

    public function getPowiat(): ?string
    {
        return $this->powiat;
    }

    public function setPowiat(string $powiat): static
    {
        $this->powiat = $powiat;

        return $this;
    }

    public function getGmina(): ?string
    {
        return $this->gmina;
    }

    public function setGmina(string $gmina): static
    {
        $this->gmina = $gmina;

        return $this;
    }

    public function getMiejscowosc(): ?string
    {
        return $this->miejscowosc;
    }

    public function setMiejscowosc(string $miejscowosc): static
    {
        $this->miejscowosc = $miejscowosc;

        return $this;
    }

    public function getKodPocztowy(): ?string
    {
        return $this->kod_pocztowy;
    }

    public function setKodPocztowy(string $kod_pocztowy): static
    {
        $this->kod_pocztowy = $kod_pocztowy;

        return $this;
    }

    public function getUlica(): ?string
    {
        return $this->ulica;
    }

    public function setUlica(string $ulica): static
    {
        $this->ulica = $ulica;

        return $this;
    }

    public function getTyp(): ?string
    {
        return $this->typ;
    }

    public function setTyp(string $typ): static
    {
        $this->typ = $typ;

        return $this;
    }

    public function getSilosID(): ?string
    {
        return $this->silosID;
    }

    public function setSilosID(string $silosID): static
    {
        $this->silosID = $silosID;

        return $this;
    }
}
