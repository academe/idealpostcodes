<?php namespace Academe\IdealPostcodes;

/**
 * Handles a set of results from the API.
 * Holds the raw data, API results codes and messages, and a
 * list of iteratable items.
 */

use Iterator;
use Countable;

abstract class Results implements Iterator, Countable
{
    /**
     * The array of items to iterate over.
     */
    protected $items = [];

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
     * Parse the top-level API response codes, and return the set of
     * results if there are any. Return NULL if there are no results.
     */
    public function parseResponse($response)
    {
        // Save a copy.
        $this->raw_response = $response;

        if (!is_array($response) || !isset($response['code'])) {
            $this->status_code = '4000';
            $this->status_message = 'No valid response received';
            return;
        }

        $this->status_code = $response['code'];
        $this->status_message = $response['message'];

        // The result element may not be set at all if the postcode did not match.
        if (isset($response['result']) && is_array($response['result'])) {
            // The result will be an array of addresses.
            return $response['result'];
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
        reset($this->items);
    }

    public function current()
    {
        $var = current($this->items);
        return $var;
    }

    public function key() 
    {
        $var = key($this->items);
        return $var;
    }

    public function next() 
    {
        $var = next($this->items);
        return $var;
    }

    public function valid()
    {
        $key = key($this->items);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }

    public function count()
    {
        return count($this->items);
    }

    /**
     * Provide a magic method to get any single field from the raw result.
     */
    public function __get($name)
    {
        return (isset($this->raw_response[$name]) ? $this->raw_response[$name] : null);
    }

    /**
     * Get all raw result fields.
     */
    public function getAll()
    {
        return $this->raw_response;
    }
}
