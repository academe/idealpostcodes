<?php namespace Academe\IdealPostcodes;

/**
 * Holds a single postcode lookup result.
 * Will itterate over the list of found addresses.
 */

use PhpCollection\Sequence;

class Postcode extends AbstractResponse
{
    /**
     * The communications helper.
     */
    protected $transport;

    /**
     * The path used in the URL.
     */
    protected $path = 'postcodes';

    /**
     * $respose is the array response from the API call.
     */
    public function __construct(TransportInterface $transport, $postcode_response = null)
    {
        $this->transport = $transport;
        $this->raw_response = $postcode_response;
    }

    /**
     * Return the URI used to fetch addresses for a postcode.
     */
    public function getUri($postcode)
    {
        $path = [$this->path, str_replace(' ', '', $postcode)];

        return $this->transport->getUri($path);
    }

    /**
     * Get all addresses for a postcode from the API.
     */
    public function getAddresses($postcode)
    {
        $url = $this->getUri($postcode);

        $response = $this->transport->get($url);

        $addresses = $this->parseResponse($response);

        $address_collection = new Sequence;

        if (!empty($addresses)) {
            foreach($addresses as $address) {
                $address_collection->add(new Address($this->transport, $address));
            }
        }

        // Return a collection of addresses.
        return $address_collection;
    }
}