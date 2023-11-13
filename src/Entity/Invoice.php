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

    #[ORM\OneToOne(inversedBy: 'invoice', cascade: ['persist', 'remove'])]
    private ?Reservation $reserve = null;

     

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

    public function getReserve(): ?Reservation
    {
        return $this->reserve;
    }

    public function setReserve(?Reservation $reserve): static
    {
        $this->reserve = $reserve;

        return $this;
    }

     
    
}
