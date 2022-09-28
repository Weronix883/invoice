<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping as ORM;

#[Entity]
class Position
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private float $net;

    #[ORM\Column]
    private float $tax;

    #[ORM\Column]
    private float $gross;

    #[ORM\ManyToOne(targetEntity: Invoice::class, inversedBy: "positions")]
    private $invoice;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNet(): float
    {
        return $this->net;
    }

    public function getTax(): float
    {
        return $this->tax;
    }

    public function getGross(): float
    {
        return $this->gross;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setNet(float $net): void
    {
        $this->net = $net;
    }

    public function setTax(float $tax): void
    {
        $this->tax = $tax;
    }

    public function setGross(float $gross): void
    {
        $this->gross = $gross;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        $invoice->addPosition($this);
        $this->invoice = $invoice;

        return $this;
    }

}
