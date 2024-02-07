<?php

namespace App\Entity;

use App\Repository\ActionStatusRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionStatusRepository::class)]
class ActionStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $rentedCar = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateRental = null;

    #[ORM\Column]
    private ?bool $returnedCar = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $returnDate = null;

    #[ORM\OneToOne(inversedBy: 'actionStatus', cascade: ['persist', 'remove'])]
    private ?Reservation $reserved = null;

    #[ORM\Column(nullable: true)]
    private ?bool $confirmed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isRentedCar(): ?bool
    {
        return $this->rentedCar;
    }

    public function setRentedCar(bool $rentedCar): static
    {
        $this->rentedCar = $rentedCar;

        return $this;
    }

    public function getDateRental(): ?\DateTimeInterface
    {
        return $this->dateRental;
    }

    public function setDateRental(\DateTimeInterface $dateRental): static
    {
        $this->dateRental = $dateRental;

        return $this;
    }

    public function isReturnedCar(): ?bool
    {
        return $this->returnedCar;
    }

    public function setReturnedCar(bool $returnedCar): static
    {
        $this->returnedCar = $returnedCar;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(\DateTimeInterface $returnDate): static
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getReserved(): ?Reservation
    {
        return $this->reserved;
    }

    public function setReserved(?Reservation $reserved): static
    {
        $this->reserved = $reserved;

        return $this;
    }

    public function isConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(?bool $confirmed): static
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    
}
