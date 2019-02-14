# Electronic Invoice To PDF

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/00af30382345413dbe6abde5cba06765)](https://app.codacy.com/app/hirale/ftetopdf?utm_source=github.com&utm_medium=referral&utm_content=hirale/ftetopdf&utm_campaign=Badge_Grade_Settings)

It's a package for generating electronic invoice xml to pdf.

## Installation

Use the package manager [composer](https://getcomposer.org/download/) to install.

```bash
composer require alefix/ftetopdf
```

## Usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Alefix\Ftetopdf;

$file = 'IT01234567890_FPA02.xml';

$pdf = new Ftetopdf();

//validate if it's a valid invoice xml, return bool and push error to array $pdf->errors
$pdf->validateXML($file);

// getInvoiceInfo() will return an array, and return 'Seller','Invoice Number','Vat Number'
$invoiceInfo = $pdf->getInvoiceInfo($file);
$filename = $invoiceInfo['Seller'] . '_' . $invoiceInfo['Invoice Number'] . '.pdf';

/**
 * topdf() has 4 params
 * @param string $filename
 * @param string $format    Mpdf output format, default is string, check mpdf output() for details
 * @param string $xslStyle
 * @param string $cssStyle
 * @return bool|\Exception|string
*/
file_put_contents($filename, $pdf->toPdf($file));

?>

```
#### Example file
- index.php
- IT01234567890_FPA02.xml
- SOCIETA'ALPHA_SRL_123.pdf


## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
