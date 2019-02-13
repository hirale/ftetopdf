<?php

namespace Alefix;

use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

/**
 * Class Ftetopdf
 * @package Alefix
 */
class Ftetopdf
{
    /**
     * @var
     */
    protected $html;
    /**
     * @var
     */
    protected $xml;

    /**
     * @param string $filename
     * @param string $xslStyle
     * @param string $cssStyle
     * @return \Exception|string
     */
    public function toPdf(string $filename, string $xslStyle = __DIR__ . '/assets/style.xsl', string $cssStyle = __DIR__ . '/assets/style.css')
    {
        if ($this->validateXML($filename)) {
            $this->toHtml($xslStyle);
            try {
                return $this->toMpdf($cssStyle);
            } catch (\Exception $e) {
                return $e;
            }
        } else {
            echo 'Fattura ' . $filename . ' Non e\' Valida';
            return false;
        }
    }

    /**
     * @return string
     */
    public function getPdfName()
    {
        $xml = $this->xml;
        if (isset($xml->getElementsByTagName('Cognome')[0]->nodeValue)) {
            $sellerName = $xml->getElementsByTagName('Nome')[0]->nodeValue . '_' . $xml->getElementsByTagName('Cognome')[0]->nodeValue;
        } else {
            $sellerName = $xml->getElementsByTagName('Denominazione')[0]->nodeValue;
        }
        $invoiceNumber = $xml->getElementsByTagName('Numero')[0]->nodeValue;
        $invoiceNumber = str_replace('/', "_", $invoiceNumber);
        $pdfName = $sellerName . '_' . $invoiceNumber . '.pdf';
        return $pdfName;
    }

    /**
     * @param $filename
     * @return bool
     */
    protected function validateXML($filename)
    {
        $xml = new \DOMDocument();
        $xml->load($filename);
        ini_set('display_errors', 0);
        if ($xml->schemaValidate(__DIR__ . '/assets/Schema_VFPR12.xsd')) {
            $this->xml = $xml;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $filename
     * @param string $style
     * @return string
     */
    protected function toHtml(string $style)
    {
        $xsl = new \DOMDocument();
        $xsl->load($style);
        $proc = new \XSLTProcessor();
        $proc->importStyleSheet($xsl);
        return $this->html = $proc->transformToXML($this->xml);
    }

    /**
     * @param string $style
     * @return string
     * @throws \Mpdf\MpdfException
     */
    protected function toMpdf(string $style)
    {
        $pdf = new Mpdf();
        $pdf->WriteHTML(file_get_contents($style), HTMLParserMode::HEADER_CSS);
        $pdf->WriteHTML($this->html, HTMLParserMode::HTML_BODY);
        return $pdf->Output('', Destination::STRING_RETURN);
    }
}