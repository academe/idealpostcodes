<?php namespace Academe\IdealPostcodes;

/**
 * Provides the HTTP transport services for access to the API.
 */

interface TransportInterface
{
    /**
     * Create a URI to the API.
     * The api_key is always inclued as a GET parameter.
     * Additional GET parameters can be added.
     * The path can be a string or an array of path parts.
     */
    public function getUri($path, $params = []);

    /**
     * Send a GET request and decode the result.
     */
    public function get($uri);
}
