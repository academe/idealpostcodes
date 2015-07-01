<?php namespace Academe\IdealPostcodes;

/**
 * Handles the Postcodes resource, allowing multiple postcodes to be fetched.
 */

class Postcodes extends Results
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
     * List of fetched postcodes.
     */
    //protected $postcodes = [];

    /**
     * The Transport object is the means to communicate with the remote service.
     */
    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }
}
