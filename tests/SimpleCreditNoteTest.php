<?php

namespace NumNum\UBL\Tests;

use NumNum\UBL\BillingReference;
use NumNum\UBL\ContractDocumentReference;
use NumNum\UBL\InvoiceDocumentReference;
use NumNum\UBL\InvoiceTypeCode;
use PHPUnit\Framework\TestCase;

/**
 * Test an UBL2.1 credit note document
 */
class SimpleCreditNoteTest extends TestCase
{
    private $schema = 'http://docs.oasis-open.org/ubl/os-UBL-2.1/xsd/maindoc/UBL-CreditNote-2.1.xsd';

    /** @test */
    public function testIfXMLIsValid()
    {
        $invoiceType = InvoiceTypeCode::CREDIT_NOTE;
        // Address country
        $country = (new \NumNum\UBL\Country())
            ->setIdentificationCode('BE');

        // Full address
        $address = (new \NumNum\UBL\Address())
            ->setStreetName('Korenmarkt')
            ->setBuildingNumber(1)
            ->setCityName('Gent')
            ->setPostalZone('9000')
            ->setCountry($country);

        // Supplier company node
        $supplierCompany = (new \NumNum\UBL\Party())
            ->setName('Supplier Company Name')
            ->setPhysicalLocation($address)
            ->setPostalAddress($address);

        // Client company node
        $clientCompany = (new \NumNum\UBL\Party())
            ->setName('My client')
            ->setPostalAddress($address);

        $legalMonetaryTotal = (new \NumNum\UBL\LegalMonetaryTotal())
            ->setPayableAmount(10 + 2)
            ->setAllowanceTotalAmount(0);

        // Tax scheme
        $taxScheme = (new \NumNum\UBL\TaxScheme())
            ->setId(0);

        // Product
        $productItem = (new \NumNum\UBL\Item())
            ->setName('Product Name')
            ->setDescription('Product Description')
            ->setSellersItemIdentification('SELLERID')
            ->setBuyersItemIdentification('BUYERID');

        // Price
        $price = (new \NumNum\UBL\Price())
            ->setBaseQuantity(1)
            ->setUnitCode(\NumNum\UBL\UnitCode::UNIT)
            ->setPriceAmount(10);

        // Invoice Line tax totals
        $lineTaxTotal = (new \NumNum\UBL\TaxTotal())
            ->setTaxAmount(2.1);

        // Invoice Line(s)
        $invoiceLine = (new \NumNum\UBL\InvoiceLine())
            ->setId(0)
            ->setItem($productItem)
            ->setPrice($price)
            ->setTaxTotal($lineTaxTotal)
            ->setInvoicedQuantity(1)
            ->setInvoiceTypeCode($invoiceType);

        $invoiceLines = [$invoiceLine];

        // Total Taxes
        $taxCategory = (new \NumNum\UBL\TaxCategory())
            ->setId(0)
            ->setName('VAT21%')
            ->setPercent(.21)
            ->setTaxScheme($taxScheme);

        $taxSubTotal = (new \NumNum\UBL\TaxSubTotal())
            ->setTaxableAmount(10)
            ->setTaxAmount(2.1)
            ->setTaxCategory($taxCategory);

        $taxTotal = (new \NumNum\UBL\TaxTotal())
            ->addTaxSubTotal($taxSubTotal)
            ->setTaxAmount(2.1);

        $invoiceDocumentReference = (new InvoiceDocumentReference())
            ->setId('123/test')
            ->setIssueDate(new \DateTime());

        $invoiceDocumentReference2 = (new InvoiceDocumentReference())
            ->setId('3432/test')
            ->setIssueDate(new \DateTime());

        $billingReference[] = (new BillingReference())
            ->setInvoiceDocumentReference($invoiceDocumentReference);

        $billingReference[] = (new BillingReference())
            ->setInvoiceDocumentReference($invoiceDocumentReference2);

        $contractDocumentReference = (new ContractDocumentReference())
            ->setId('555/test');
        // Invoice object
        $invoice = (new \NumNum\UBL\Invoice())
            ->setId(1234)
            ->setCopyIndicator(false)
            ->setIssueDate(new \DateTime())
            ->setAccountingSupplierParty($supplierCompany)
            ->setAccountingCustomerParty($clientCompany)
            ->setInvoiceLines($invoiceLines)
            ->setLegalMonetaryTotal($legalMonetaryTotal)
            ->setTaxTotal($taxTotal)
            ->setBillingReference($billingReference)
            ->setContractDocumentReference($contractDocumentReference)
            ->setInvoiceTypeCode($invoiceType);

        // Test created object
        // Use \NumNum\UBL\Generator to generate an XML string
        $generator = new \NumNum\UBL\Generator();
        $outputXMLString = $generator->invoice($invoice);

        // Create PHP Native DomDocument object, that can be
        // used to validate the generate XML
        $dom = new \DOMDocument;
        $dom->loadXML($outputXMLString);

        $dom->save('./tests/SimpleCreditNoteTest.xml');

        $this->assertEquals(true, $dom->schemaValidate($this->schema));
    }
}
