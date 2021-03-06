<?php

namespace App\Entity;


class ProductFilter
{
    
    private $category;

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }
  }
