<?php

namespace NumNum\UBL;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class InvoicedPrepaymentAmmount implements XmlSerializable
{
    private $id;
    private $taxTotal;
    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return InvoicedPrepaymentAmmount
     */
    public function setId(string $id): InvoicedPrepaymentAmmount
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return TaxTotal
     */
    public function getTaxTotal(): ?TaxTotal
    {
        return $this->taxTotal;
    }

    /**
     * @param TaxTotal $taxTotal
     * @return InvoicedPrepaymentAmmount
     */
    public function setTaxTotal(TaxTotal $taxTotal): InvoicedPrepaymentAmmount
    {
        $this->taxTotal = $taxTotal;
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
        $writer->write([ Schema::CBC . 'ID' => $this->id ]);

        if ($this->taxTotal !== null) {
            $writer->write([
                Schema::CAC . 'TaxTotal' => $this->taxTotal
            ]);
        }
    }
}
