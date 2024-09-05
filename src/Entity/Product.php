<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $price;


    
    // Getter for id
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter for name
    public function getName(): ?string
    {
        return $this->name;
    }

    // Setter for name
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    // Getter for description
    public function getDescription(): ?string
    {
        return $this->description;
    }

    // Setter for description
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    // Getter for price
    public function getPrice(): ?string
    {
        return $this->price;
    }

    // Setter for price
    public function setPrice(string $price): self
    {
        $this->price = $price;
        return $this;
    }

    // ... other methods ...
}
