# IdealPostcodes

Library to access the Ideal Postcodes API.
The main documentation for the API is here:
https://ideal-postcodes.co.uk/documentation/paf-data#longitude

Still much work-in-progress, but a working library. 

Example use, to fetch a list of addresses matching a postcode:

~~~php
use Academe\IdealPostcodes\Postcode;
use Academe\IdealPostcodes\Transport;

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
use Academe\IdealPostcodes\GeoLocation;
use Academe\IdealPostcodes\Transport;

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

Search for addresses:

~~~php
use Academe\IdealPostcodes\Address;
use Academe\IdealPostcodes\Transport;

$transport = new Transport('iddqd');
$addr = new Address($transport);

$addresses = $addr->search('10 Downing Street');

foreach($addresses as $address) {
    echo $postcode->town . "<br>";
}
~~~

Get a single address by its ID (UDPRN):

~~~php
use Academe\IdealPostcodes\Address;
use Academe\IdealPostcodes\Transport;

$transport = new Transport('iddqd');
$addr = new Address($transport);

$address = $addr->get(0);

var_dump($address->toArray());
~~~

## TODO

* Keys API
* More documnentation
* Tests
* Consider an adapter for the collection, so other collections can be used
