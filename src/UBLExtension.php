<?php

namespace NumNum\UBL;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class UBLExtension implements XmlSerializable
{
    private $invoicedPrepaymentAmmounts = [];
    private $reducedTotals;

    /**
     * @return array
     */
    public function getInvoicedPrepaymentAmmounts(): array
    {
        return $this->invoicedPrepaymentAmmounts;
    }

    /**
     * @param InvoicedPrepaymentAmmount $invoicedPrepaymentAmmount
     * @return UBLExtension
     */
    public function addInvoicedPrepaymentAmmounts(InvoicedPrepaymentAmmount $invoicedPrepaymentAmmount): UBLExtension
    {
        $this->invoicedPrepaymentAmmounts[] = $invoicedPrepaymentAmmount;
        return $this;
    }

    /**
     * @return ReducedTotals
     */
    public function getReducedTotals(): ?ReducedTotals
    {
        return $this->reducedTotals;
    }

    /**
     * @param ReducedTotals $invoicePeriod
     * @return UBLExtension
     */
    public function setReducedTotals(ReducedTotals $reducedTotals): UBLExtension
    {
        $this->reducedTotals = $reducedTotals;
        return $this;
    }

    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        foreach ($this->invoicedPrepaymentAmmounts as $invoicedPrepaymentAmmount) {
            $writer->write([Schema::XSD . 'InvoicedPrepaymentAmmount' => $invoicedPrepaymentAmmount]);
        }
        if ($this->reducedTotals != null)
            $writer->write([Schema::XSD . 'ReducedTotals' => $this->reducedTotals]);
    }
}
