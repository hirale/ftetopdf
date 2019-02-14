<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Ftetopdf.php';

use Alefix\Ftetopdf;

$file = 'IT01234567890_FPA02.xml';
$pdf = new Ftetopdf();
$invoiceInfo = $pdf->getInvoiceInfo($file);
$pdf->validateXML($file);
$filename = $invoiceInfo['Seller'] . '_' . $invoiceInfo['Invoice Number'] . '.pdf';
file_put_contents($filename, $pdf->toPdf($file));