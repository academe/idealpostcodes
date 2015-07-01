<?php namespace Academe\IdealPostcodes;

/**
 * Handles responses from the API.
 * Holds the raw data, API results codes and messages.
 */

use JsonSerializable;

abstract class AbstractResponse implements JsonSerializable
{
    /**
     * The communications helper.
     */
    protected $transport;

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
     * Provide a magic method to get any single field from the raw result.
     */
    public function __get($name)
    {
        return (isset($this->raw_response[$name]) ? $this->raw_response[$name] : null);
    }

    /**
     * Get all raw result fields.
     */
    public function toArray()
    {
        return $this->raw_response;
    }

    /**
     * Used when serialising an address as JSON.
     * Serialises just the raw data and not the API result.
     */
    public function jsonSerialize() {
        return $this->toArray();
    }
}
