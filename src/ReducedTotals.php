<?php

namespace NumNum\UBL;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class ReducedTotals implements XmlSerializable
{
    private $taxTotal;
    private $legalMonetaryTotal;

    /**
     * @return TaxTotal
     */
    public function getTaxTotal(): ?TaxTotal
    {
        return $this->taxTotal;
    }

    /**
     * @param TaxTotal $taxTotal
     * @return ReducedTotals
     */
    public function setTaxTotal(TaxTotal $taxTotal): ReducedTotals
    {
        $this->taxTotal = $taxTotal;
        return $this;
    }

    /**
     * @return LegalMonetaryTotal
     */
    public function getLegalMonetaryTotal(): ?LegalMonetaryTotal
    {
        return $this->legalMonetaryTotal;
    }

    /**
     * @param LegalMonetaryTotal $legalMonetaryTotal
     * @return ReducedTotals
     */
    public function setLegalMonetaryTotal(LegalMonetaryTotal $legalMonetaryTotal): ReducedTotals
    {
        $this->legalMonetaryTotal = $legalMonetaryTotal;
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
        if ($this->taxTotal !== null) {
            $writer->write([
                Schema::CAC . 'TaxTotal' => $this->taxTotal
            ]);
        }

        $writer->write([
            Schema::CAC . 'LegalMonetaryTotal' => $this->legalMonetaryTotal
        ]);
    }
}
