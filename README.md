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

// getInvoiceInfo() will return an array, and return 'Seller','Invoice Number','Vat Number'
$invoiceInfo = $pdf->getInvoiceInfo($file);
$filename = $invoiceInfo['Seller'] . '_' . $invoiceInfo['Invoice Number'] . '.pdf';

// topdf() return string of generated pdf.
file_put_contents($filename, $pdf->toPdf($file));

?>
```

If file xml is not a valid invoice xml, it will push the error to errors array(default is empty), you can detect errors like this
```php
if (empty($pdf->errors))
{
    //code here.
}

```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
