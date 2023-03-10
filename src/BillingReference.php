<?php

namespace NumNum\UBL;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class BillingReference implements XmlSerializable
{
    private $invoiceDocumentReference;

    /**
     * @return invoiceDocumentReference
     */
    public function getInvoiceDocumentReference(): ?invoiceDocumentReference
    {
        return $this->invoiceDocumentReference;
    }

    /**
     * @param invoiceDocumentReference $invoiceDocumentReference
     * @return BillingReference
     */
    public function setInvoiceDocumentReference(invoiceDocumentReference $invoiceDocumentReference): BillingReference
    {
        $this->invoiceDocumentReference = $invoiceDocumentReference;
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
        if ($this->invoiceDocumentReference != null) {
            $writer->write([
                Schema::CAC . 'InvoiceDocumentReference' => $this->invoiceDocumentReference
            ]);
        }
    }
}
