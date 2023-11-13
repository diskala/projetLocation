<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Nullable;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column]
    private ?bool $bail = null;

    #[ORM\Column(nullable: true)]
    private ?bool $option_driver = null;

    #[ORM\Column(nullable: true)]
    private ?bool $opt_child_seat = null;

    #[ORM\Column(nullable: true)]
    private ?bool $decoration = null;
    
    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Car $car = null;

    #[ORM\ManyToOne(inversedBy: 'reserved')]
    private ?User $users = null;

    #[ORM\OneToOne(mappedBy: 'reserve', cascade: ['persist', 'remove'])]
    private ?Invoice $invoice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function isBail(): ?bool
    {
        return $this->bail;
    }

    public function setBail(bool $bail): static
    {
        $this->bail = $bail;

        return $this;
    }

    public function isOptionDriver(): ?bool
    {
        return $this->option_driver;
    }

    public function setOptionDriver(?bool $option_driver): static
    {
        $this->option_driver = $option_driver;

        return $this;
    }

    public function isOptChildSeat(): ?bool
    {
        return $this->opt_child_seat;
    }

    public function setOptChildSeat(?bool $opt_child_seat): static
    {
        $this->opt_child_seat = $opt_child_seat;

        return $this;
    }

    public function isDecoration(): ?bool
    {
        return $this->decoration;
    }

    public function setDecoration(?bool $decoration): static
    {
        $this->decoration = $decoration;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): static
    {
        $this->car = $car;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): static
    {
        $this->users = $users;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): static
    {
        // unset the owning side of the relation if necessary
        if ($invoice === null && $this->invoice !== null) {
            $this->invoice->setReserve(null);
        }

        // set the owning side of the relation if necessary
        if ($invoice !== null && $invoice->getReserve() !== $this) {
            $invoice->setReserve($this);
        }

        $this->invoice = $invoice;

        return $this;
    }

        
}
