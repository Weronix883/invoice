<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private string $buyer;

    #[ORM\Column]
    private string $supplier;

    #[ORM\Column]
    private float $net;

    #[ORM\Column]
    private float $tax;

    #[ORM\Column]
    private float $gross;

    #[ORM\Column]
    private string $currency;

    #[ORM\OneToMany(mappedBy: 'invoice', targetEntity: Position::class, cascade: ['remove'])]
    private $positions;

    public function __construct()
    {
        $this->positions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBuyer(): string
    {
        return $this->buyer;
    }

    public function setBuyer(string $buyer): void
    {
        $this->buyer = $buyer;
    }

    public function setSupplier(string $supplier): void
    {
        $this->supplier = $supplier;
    }

    public function getSupplier(): string
    {
        return $this->supplier;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function setNet(float $net): void
    {
        $this->net = $net;
    }

    public function getNet(): float
    {
        return $this->net;
    }

    public function setTax(float $tax): void
    {
        $this->tax = $tax;
    }

    public function getTax(): float
    {
        return $this->tax;
    }

    public function setGross(float $gross): void
    {
        $this->gross = $gross;
    }

    public function getGross(): float
    {
        return $this->gross;
    }

    public function getPositions(): ArrayCollection
    {
        return $this->positions;
    }

    public function addPosition(Position $position): self
    {
        if (! $this->positions->contains($position)) {
            $this->positions[] = $position;
            $position->setInvoice($this);
        }

        return $this;
    }

    public function removePosition(Position $position): self
    {
        if($this->positions->removeElement($position)) {
            if ($position->getInvoice() === $this) {
                $position->setInvoice(null);
            }
        }

        return $this;
    }

}
