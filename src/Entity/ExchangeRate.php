<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExchangeRateRepository")
 */
class ExchangeRate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $currencyName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $currencyCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $exchangeCurrency;

    /**
     * @ORM\Column(type="float")
     */
    private $exchangeValue;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrencyName(): ?string
    {
        return $this->currencyName;
    }

    public function setCurrencyName(string $currencyName): self
    {
        $this->currencyName = $currencyName;

        return $this;
    }

    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode($currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

    public function getExchangeCurrency(): ?string
    {
        return $this->exchangeCurrency;
    }

    public function setExchangeCurrency(string $exchangeCurrency): self
    {
        $this->exchangeCurrency = $exchangeCurrency;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExchangeValue()
    {
        return $this->exchangeValue;
    }

    /**
     * @param mixed $exchangeValue
     */
    public function setExchangeValue($exchangeValue): void
    {
        $this->exchangeValue = $exchangeValue;
    }
}
