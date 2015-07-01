<?php namespace Academe\IdealPostcodes;

/**
 * Holds a single postcode lookup result.
 */

class Address extends AbstractResponse
{
    /**
     * $address_respose is the array response from the API call.
     */
    public function __construct(Transport $transport, $address_response = null)
    {
        $this->transport = $transport;
        $this->raw_response = $address_response;
    }
}

