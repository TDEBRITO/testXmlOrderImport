<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerOrderRepository")
 */
class CustomerOrder
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var ExchangeRate
     *
     * @ORM\ManyToOne(targetEntity="ExchangeRate")
     */
    private $currency;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var Product
     *
     * @ORM\ManyToMany(targetEntity="Product")
     */
    private $products;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return ExchangeRate
     */
    public function getCurrency(): ExchangeRate
    {
        return $this->currency;
    }

    /**
     * @param ExchangeRate $currency
     */
    public function setCurrency(ExchangeRate $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @param Product $product
     *
     * @return $this
     */
    public function addProduct(Product $product)
    {
        if (!$this->getProducts()->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * @return Product|ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param $total
     */
    public function setTotal($total): void
    {
        $this->total = $total;
    }
}
