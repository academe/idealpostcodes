<?php namespace Academe\IdealPostcodes;

/**
 * Provides the HTTP transport services for access to the API.
 */

class Transport
{
    /**
     * The api_key for the account.
     */
    protected $api_key;

    /**
     * The API version to use.
     */
    protected $version = 'v1';

    /**
     * The API base endpoint.
     */
    protected $endpoint = 'https://api.ideal-postcodes.co.uk';

    /**
     * Credendtials are supplied on instantiation of the Transport object.
     */
    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * Create a URI to the API.
     * The api_key is always inclued as a GET parameter.
     * Additional GET parameters can be added.
     * The path can be a string or an array of path parts.
     */
    public function getUri($path, $params = [])
    {
        $url_parts = [
            $this->endpoint,
            $this->version,
        ];

        if (is_array($path)) {
            $url_parts = array_merge($url_parts, array_map('rawurlencode', $path));
        } else {
            // We assume the string path is correctly encoded.
            $url_parts[] = trim($path, '/');
        }

        // Merge any parameters passed in with the API key, as the API key
        // is always needed.
        $params = array_merge(['api_key' => $this->api_key], $params);

        return implode('/', $url_parts) . '?' . http_build_query($params);
    }

    /**
     * Send a GET request and decode the result.
     */
    public function get($uri)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $uri);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $body = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($body, true);

        return $response;
    }
}
