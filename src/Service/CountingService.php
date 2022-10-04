<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Invoice;
use App\Entity\Position;

class CountingService
{
    public function countPositionGross(Position $position): Position
    {
        $position->setGross(($position->getNet() / 100) * $position->getTax() + $position->getNet());

        return $position;
    }

    public function countInvoiceNet(Invoice $invoice): void
    {
        $net = 0;
        foreach ($invoice->getPositions() as $position) {
            $net += $position->getNet();
        }
        $invoice->setNet($net);
    }

    public function countInvoiceTax(Invoice $invoice): void
    {
        $tax = 0;
        foreach ($invoice->getPositions() as $position) {
            $tax += ($position->getNet() / 100) * $position->getTax();
        }
        $invoice->setTax($tax);
    }

    public function countInvoiceGross(Invoice $invoice): void
    {
        $gross = 0;
        foreach ($invoice->getPositions() as $position) {
            $gross += ($position->getGross());
        }
        $invoice->setGross($gross);
    }

    public function countInvoice(Invoice $invoice): void
    {
        $this->countInvoiceNet($invoice);
        $this->countInvoiceTax($invoice);
        $this->countInvoiceGross($invoice);
    }
}
