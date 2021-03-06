# IdealPostcodes

[![Latest Stable Version](https://poser.pugx.org/academe/idealpostcodes/version.png)](https://packagist.org/packages/academe/idealpostcodes)
[![Total Downloads](https://poser.pugx.org/academe/idealpostcodes/d/total.png)](https://packagist.org/packages/academe/idealpostcodes)

Library to access the [Ideal Postcodes](https://ideal-postcodes.co.uk/) API.
The main documentation for the API is here:
https://ideal-postcodes.co.uk/documentation

Still much work-in-progress, but a working library. This package is not associated officially with *Ideal Postcodes*.

## General Approach

This is the general approach I have taken in developing this library. It was all initially written in one day 
to meet a need for a specific project, so may be a bit rushed, but I have tried to keep it as generic as
possible. It does need extending out with more interfaces though, and perhaps make the most of a DI locator 
so classes can be extended as needed.

Communication with the remote API happens in the `Transport` object. Instantiate that with your API key
and pass that into the other classes. This class uses curl to communicate, but you may want to create
a guzzle version or use a different http client - just write an adapter and you should be good.

Each value class searves two purposes:

* To hold the value of a single, retrieved record from the API.
* To make requests on the API.

So if you want to find, for example, addresses for a postcode, instantiate the Postcode object then use its
`getAddresses($postcode)` method to fetch a collection of Address objects for a postcode. The Postcode object
will hold the summary of the interaction with the API (the result, any messages etc) while the `getAddresses()`
method will return a collection.

The collections are provided by the `phpcollection/phpcollection` composer package. This is a new and largely
untested package, but seemed to meet the needs here nicely. I intend to make the collections more generic
in the future, so you are not tied down to just one collections implementation.

## Examples

Example use, to fetch a list of addresses matching a postcode:

~~~php
use Academe\IdealPostcodes\Postcode;
use Academe\IdealPostcodes\Transport;

// 'iddqd' is the shared developer API key, limited to 15 requests per day for each IP address.
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

* Keys API. This includes CSV download, which could be streamed to help with memory usage.
* More and better documnentation.
* Tests.
* Consider an adapter for the collection, so other collections can be used.
* The collections are not JSON serialisable; it would help if they are; use $collection->all() and serialise that for now
* More helper methods to interpret the API codes that are received, to make it easier to identify http errors, failure to find a match, and so on.
* Maybe consider putting all the request methods into a single class and returning Postcodes, Addresses and colletions of either from there. That way the records can be true value objects. 
The methods are spread over multiple classes just for history reasons, and is probably not an optimal approach.
* Support for query tags, which are available across all API methods.
