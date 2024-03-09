<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $brand = null;

    #[ORM\Column(length: 100)]
    private ?string $model = null;

    #[ORM\Column(length: 100)]
    private ?string $category = null;

    #[ORM\Column(length: 100)]
    private ?string $energy = null;

    #[ORM\Column(length: 100)]
    private ?string $power = null;

    #[ORM\Column(length: 100)]
    private ?string $gear_box = null;

    #[ORM\Column]
    private ?string $number_place = null;

    #[ORM\Column]
    private ?float $price_day = null;

    #[ORM\Column]
    private ?float $price_DPKM = null;

    #[ORM\Column]
    private ?float $price_km_unlimited = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column]
    private ?float $bail = null;

    #[ORM\Column]
    private ?bool $available = null;

    #[ORM\Column(nullable: true)]
    private ?int $priceSeatChild = null;

    #[ORM\Column(nullable: true)]
    private ?int $priceDecoration = null;

    #[ORM\Column(nullable: true)]
    private ?int $priceDriver = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Image $image = null;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Reservation::class)]
    private Collection $reservations;

    #[ORM\Column(length: 255)]
    private ?string $quantity = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getEnergy(): ?string
    {
        return $this->energy;
    }

    public function setEnergy(string $energy): static
    {
        $this->energy = $energy;

        return $this;
    }

    public function getPower(): ?string
    {
        return $this->power;
    }

    public function setPower(string $power): static
    {
        $this->power = $power;

        return $this;
    }

    public function getGearBox(): ?string
    {
        return $this->gear_box;
    }

    public function setGearBox(string $gear_box): static
    {
        $this->gear_box = $gear_box;

        return $this;
    }

    public function getNumberPlace(): ?string
    {
        return $this->number_place;
    }

    public function setNumberPlace(int $number_place): static
    {
        $this->number_place = $number_place;

        return $this;
    }

    public function getPriceDay(): ?float
    {
        return $this->price_day;
    }

    public function setPriceDay(float $price_day): static
    {
        $this->price_day = $price_day;

        return $this;
    }

    public function getPriceDPKM(): ?float
    {
        return $this->price_DPKM;
    }

    public function setPriceDPKM(float $price_DPKM): static
    {
        $this->price_DPKM = $price_DPKM;

        return $this;
    }

    public function getPriceKmUnlimited(): ?float
    {
        return $this->price_km_unlimited;
    }

    public function setPriceKmUnlimited(float $price_km_unlimited): static
    {
        $this->price_km_unlimited = $price_km_unlimited;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getBail(): ?float
    {
        return $this->bail;
    }

    public function setBail(float $bail): static
    {
        $this->bail = $bail;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): static
    {
        $this->available = $available;

        return $this;
    }

    public function getPriceSeatChild(): ?int
    {
        return $this->priceSeatChild;
    }

    public function setPriceSeatChild(?int $priceSeatChild): static
    {
        $this->priceSeatChild = $priceSeatChild;

        return $this;
    }

    public function getPriceDecoration(): ?int
    {
        return $this->priceDecoration;
    }

    public function setPriceDecoration(?int $priceDecoration): static
    {
        $this->priceDecoration = $priceDecoration;

        return $this;
    }

    public function getPriceDriver(): ?int
    {
        return $this->priceDriver;
    }

    public function setPriceDriver(?int $priceDriver): static
    {
        $this->priceDriver = $priceDriver;

        return $this;
    }
     
    public function __toString()
    {
        
        
      return $this->getBrand(); // Replace with the property or method you want to use as a string representation
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setCar($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getCar() === $this) {
                $reservation->setCar(null);
            }
        }

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    
     
     

     

}
