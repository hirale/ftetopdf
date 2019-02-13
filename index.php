<?php

require __DIR__ . '/vendor/autoload.php';

use Alefix\Ftetopdf;

foreach (glob('*.xml') as $file) {
    $pdf = new Ftetopdf();
    $pdfName = $pdf->getInvoiceInfo($file);
    file_put_contents($pdfName['Seller'] . '_' . $pdfName['Invoice Number'] . '.pdf', $pdf->toPdf($file));
}