<?php

namespace NumNum\UBL;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use DateTime;

class InvoiceDocumentReference implements XmlSerializable
{
    private $id;
    private $issueDate;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return InvoiceDocumentReference
     */
    public function setId(string $id): InvoiceDocumentReference
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getIssueDate(): ?DateTime
    {
        return $this->issueDate;
    }

    /**
     * @param DateTime $issueDate
     * @return InvoiceDocumentReference
     */
    public function setIssueDate(DateTime $issueDate): InvoiceDocumentReference
    {
        $this->issueDate = $issueDate;
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
        if ($this->id !== null) {
            $writer->write([ Schema::CBC . 'ID' => $this->id ]);
        }
        if ($this->issueDate !== null) {
            $writer->write([
                Schema::CBC . 'IssueDate' => $this->issueDate->format('Y-m-d'),
            ]);
        }
    }
}
