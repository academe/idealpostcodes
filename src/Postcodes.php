<?php namespace Academe\IdealPostcodes;

/**
 * Handles the Postcodes resource, allowing multiple postcodes to be fetched.
 */

class Postcodes
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
     * The Transport object is the means to communicate with the remote service.
     */
    public function __construct(Transport $transport)
    {
        $this->transport = $transport;
    }

    /**
     * Return the URI used to fetch addresses for a postcode.
     */
    public function getPostcodeUri($postcode)
    {
        $path = [$this->path, str_replace(' ', '', $postcode)];

        return $this->transport->getUri($path);
    }

    /**
     * Get all addresses for a postcode.
     */
    public function postcodeLookup($postcode)
    {
        $url = $this->getPostcodeUri($postcode);
        $response = $this->transport->get($url);

        return new Postcode($response);
    }
}
