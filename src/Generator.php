<?php

namespace NumNum\UBL;

use Sabre\Xml\Service;

class Generator
{
    public static $currencyID;

    public static function invoice(Invoice $invoice, $currencyId = 'EUR')
    {
        self::$currencyID = $currencyId;

        $xmlService = new Service();

        if($invoice->getInvoiceTypeCode() == InvoiceTypeCode::CREDIT_NOTE){
            $xmlService->namespaceMap = [
                'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2' => 'cec',
                'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2' => 'cac',
                'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2' => 'cbc',
                'http://www.w3.org/2001/XMLSchema-instance' => 'xsi',
                'http://www.w3.org/2001/XMLSchema' => 'xsd',
                'http://mfin.gov.rs/srbdt/srbdtext' => 'sbt',
                'urn:oasis:names:specification:ubl:schema:xsd:CreditNote-2' => '',
            ];
            return $xmlService->write('CreditNote', [
                $invoice
            ]);
        }
            $xmlService->namespaceMap = [
                'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2' => 'cec',
                'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2' => 'cac',
                'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2' => 'cbc',
                'http://www.w3.org/2001/XMLSchema-instance' => 'xsi',
                'http://www.w3.org/2001/XMLSchema' => 'xsd',
                'http://mfin.gov.rs/srbdt/srbdtext' => 'sbt',
                'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2' => '',
            ];

        return $xmlService->write('Invoice', [
            $invoice
        ]);
    }
}
