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

    #[ORM\Column(type:"string", nullable:true)]
    private ?float $price_TTC = null;

    #[ORM\OneToOne(inversedBy: 'invoice', cascade: ['persist', 'remove'])]
    private ?Reservation $reserve = null;

    #[ORM\Column(type:"string")]
    private ?string $number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $facturePdf = null;

     

    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getPriceTTC(): ?string
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

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function __toString()
    {
        
    
return $this->getId(); // Replace with the property or method you want to use as a string representation
    } 



     /**
     * Génère un numéro de facture unique en utilisant l'ID de la réservation.
     */
    public function generateInvoiceNumber() 
    {
        // Préfixe de la facture (peut être personnalisé selon vos besoins)
        $prefix = 'INV';

        // Identifiant unique de la réservation
        $uniId = random_int(11111 , 99999);

        // Partie de la date actuelle (année, mois, jour)
        $datePart = date('Ymd');

        // Combine les éléments pour former le numéro de facture
        $this->number = $prefix . '-'.'-' . $uniId;
    }

    public function getFacturePdf(): ?string
    {
        return $this->facturePdf;
    }

    public function setFacturePdf(?string $facturePdf): static
    {
        $this->facturePdf = $facturePdf;

        return $this;
    }
    
}
