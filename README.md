# IdealPostcodes
Library to access the Ideal Postcodes API

Still much work-in-progress.

Example use, to fetch a list of addresses matching a postcode:

~~~php
use use Academe\IdealPostcodes\Postcode;
use use Academe\IdealPostcodes\Transport;

$transport = new Transport('iddqd');
$postcode = new Postcode($transport);
$addresses = $postcode->getAddresses('ID1 1QD');

foreach($addresses as $address) {
    echo $address->line_1 . "<br>";
}

echo "Number of addresses = " . count($addresses);
~~~

Get up to 20 postcodes in a 300m radius around a latitude/longitude location:

~~~php
use use Academe\IdealPostcodes\GeoLocation;
use use Academe\IdealPostcodes\Transport;

$transport = new Transport('iddqd');
$geo = new GeoLocation($transport);
$postcodes = $geo->getPostcodes(-0.20864436, 51.48994883, 20, 300);

foreach($postcodes as $postcode) {
    echo $postcode->postcode . "<br>";
    echo $postcode->northings . "<br>";
    echo $postcode->eastings . "<br>";
}

echo "Number of postcodes = " . count($postcodes);
~~~
