<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $image_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_6 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_7 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_8 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_9 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_10 = null;

    #[ORM\OneToOne(inversedBy: 'pic', cascade: ['persist', 'remove'])]
    private ?Car $car = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getImage1(): ?string
    {
        return $this->image_1;
    }

    public function setImage1(string $image_1): static
    {
        $this->image_1 = $image_1;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image_2;
    }

    public function setImage2(?string $image_2): static
    {
        $this->image_2 = $image_2;

        return $this;
    }

    public function getImage3(): ?string
    {
        return $this->image_3;
    }

    public function setImage3(?string $image_3): static
    {
        $this->image_3 = $image_3;

        return $this;
    }

    public function getImage4(): ?string
    {
        return $this->image_4;
    }

    public function setImage4(?string $image_4): static
    {
        $this->image_4 = $image_4;

        return $this;
    }

    public function getImage5(): ?string
    {
        return $this->image_5;
    }

    public function setImage5(?string $image_5): static
    {
        $this->image_5 = $image_5;

        return $this;
    }

    public function getImage6(): ?string
    {
        return $this->image_6;
    }

    public function setImage6(?string $image_6): static
    {
        $this->image_6 = $image_6;

        return $this;
    }

    public function getImage7(): ?string
    {
        return $this->image_7;
    }

    public function setImage7(?string $image_7): static
    {
        $this->image_7 = $image_7;

        return $this;
    }

    public function getImage8(): ?string
    {
        return $this->image_8;
    }

    public function setImage8(?string $image_8): static
    {
        $this->image_8 = $image_8;

        return $this;
    }

    public function getImage9(): ?string
    {
        return $this->image_9;
    }

    public function setImage9(?string $image_9): static
    {
        $this->image_9 = $image_9;

        return $this;
    }

    public function getImage10(): ?string
    {
        return $this->image_10;
    }

    public function setImage10(?string $image_10): static
    {
        $this->image_10 = $image_10;

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
}
