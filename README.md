# IdealPostcodes
Library to access the Ideal Postcodes API

Still much work-in-progress.

Example use, to fetch a list of addresses matching a postcode:

~~~php
use use Academe\IdealPostcodes\Postcode;
use use Academe\IdealPostcodes\Transport;

$transport = new Transport('iddqd');
$postcode = new Postcode($transport);
$postcode->getAddresses('ID1 1QD');

foreach($postcode as $address) {
    echo $address->line_1 . "<br>";
}

echo "Number of addresses = " . count($postcode);

~~~

