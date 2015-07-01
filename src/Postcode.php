<?php namespace Academe\IdealPostcodes;

/**
 * Holds a single postcode lookup result.
 * Will itterate over the list of found addresses.
 */

use Iterator;
use Countable;

class Postcode implements Iterator, Countable
{
    /**
     * List of addresses found for this postcode.
     */
    protected $addresses = [];

    /**
     * The status of the API result.
     */
    protected $status_code;

    /**
     * The message from the API result.
     */
    protected $status_message;

    /**
     * The raw response, for inspection when debugging.
     */
    protected $raw_response;

    /**
     * $respose is the array response from the API call.
     */
    public function __construct($response)
    {
        // Save a copy.
        $this->raw_response = $response;

        // Parse the response into components.
        $this->parseResponse($response);
    }

    public function parseResponse($response)
    {
        if (!is_array($response) || !isset($response['code'])) {
            $this->status_code = '4000';
            $this->status_message = 'No valid response received';
            return;
        }

        $this->status_code = $response['code'];
        $this->status_message = $response['message'];

        if (is_array($response['result'])) {
            // The result will be an array of addresses.
            foreach($response['result'] as $address) {
                $this->addresses[] = new Address($address);
            }
        }
    }

    public function getCode()
    {
        return $this->status_code;
    }

    public function getMessage()
    {
        return $this->status_message;
    }

    /**
     * Iterator methods.
     */
    public function rewind()
    {
        reset($this->addresses);
    }

    public function current()
    {
        $var = current($this->addresses);
        return $var;
    }

    public function key() 
    {
        $var = key($this->addresses);
        return $var;
    }

    public function next() 
    {
        $var = next($this->addresses);
        return $var;
    }

    public function valid()
    {
        $key = key($this->addresses);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }

    public function count()
    {
        return count($this->addresses);
    }
}