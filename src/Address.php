<?php namespace Academe\IdealPostcodes;

/**
 * Holds a single postcode lookup result.
 */

class Address extends Results
{
    /**
     * The raw address data.
     */
    protected $raw_response;

    /**
     * $address_respose is the array response from the API call.
     */
    public function __construct(Transport $transport, $address_response)
    {
        // Save a copy.
        $this->raw_response = $address_response;
    }
}

