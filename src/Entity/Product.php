<?php

// src/Entity/Product.php
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
    private $description; // Ensure this is defined

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $price;

    // ... other fields and methods ...
}