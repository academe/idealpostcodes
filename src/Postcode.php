<?php namespace Academe\IdealPostcodes;

/**
 * Holds a single postcode lookup result.
 * Will itterate over the list of found addresses.
 */

class Postcode extends Results
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
    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
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
     * Get all addresses for a postcode.
     */
    public function getAddresses($postcode)
    {
        $url = $this->getUri($postcode);

        $response = $this->transport->get($url);

        $addresses = $this->parseResponse($response);

        if (!empty($addresses)) {
            foreach($addresses as $address) {
                $this->items[] = new Address($this->transport, $address);
            }
        }

        return $this;
    }
}