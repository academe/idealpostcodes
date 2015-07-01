<?php namespace Academe\IdealPostcodes;

/**
 * Holds a single postcode lookup result.
 */

class Address
{
    /**
     * The raw address data.
     */
    protected $raw_response;

    /**
     * $address_respose is the array response from the API call.
     */
    public function __construct($address_response)
    {
        // Save a copy.
        $this->raw_response = $address_response;
    }

    /**
     * Provide a magic method to get any address field.
     */
    public function __get($name)
    {
        return (isset($this->raw_response[$name]) ? $this->raw_response[$name] : null);
    }

    /**
     * Provide a magic method to get any address field.
     */
    public function getAll()
    {
        return $this->raw_response;
    }
}

