<?php namespace Academe\IdealPostcodes;

/**
 * Holds a single postcode lookup result.
 * Will itterate over the list of found addresses.
 */

use PhpCollection\Sequence;

class GeoLocation extends Postcode
{
    /**
     * Return the URI used to fetch addresses for a postcode.
     */
    public function getUri($params)
    {
        return $this->transport->getUri([$this->path], $params);
    }

    /**
     * Get postcodes for a geographic location from the API.
     * The radius ranges up to 1000m, and defaults to 100m.
     * The limit ranges up to 150, defauling to 100.
     *
     * @param longitude decimal The location WGS84 longitude.
     * @param latitude decimal The location WGS84 latitude.
     * @param radius integer The radius in metres (up to 1000, default 100).
     * @param limit integer The radius in metres (up to 150, default 100).
     */
    public function getPostcodes($longitude, $latitude, $radius = null, $limit = null)
    {
        $lonlat = $longitude . ',' . $latitude;

        $params = ['lonlat' => $lonlat];

        if (isset($radius)) {
            $params['radius'] = $radius;
        }

        if (isset($limit)) {
            $params['limit'] = $limit;
        }

        $url = $this->getUri($params);

        $response = $this->transport->get($url);

        $postcodes = $this->parseResponse($response);

        $postcode_collection = new Sequence;

        if (!empty($postcodes)) {
            foreach($postcodes as $postcode) {
                $postcode_collection->add(new Postcode($this->transport, $postcode));
            }
        }

        // Return a collection of postcodes.
        return $postcode_collection;
    }
}
