<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $price_HT = null;

    #[ORM\Column]
    private ?float $price_TTC = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Reservation $Reservation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriceHT(): ?float
    {
        return $this->price_HT;
    }

    public function setPriceHT(float $price_HT): static
    {
        $this->price_HT = $price_HT;

        return $this;
    }

    public function getPriceTTC(): ?float
    {
        return $this->price_TTC;
    }

    public function setPriceTTC(float $price_TTC): static
    {
        $this->price_TTC = $price_TTC;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->Reservation;
    }

    public function setReservation(?Reservation $Reservation): static
    {
        $this->Reservation = $Reservation;

        return $this;
    }
}
