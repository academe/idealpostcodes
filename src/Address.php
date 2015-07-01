<?php namespace Academe\IdealPostcodes;

/**
 * Holds a single postcode lookup result.
 */

use PhpCollection\Sequence;

class Address extends AbstractResponse
{
    /**
     * The path used in the URL.
     */
    protected $path = 'addresses';

    /**
     * The total number of addresses found in a search.
     */
    protected $total = 0;

    /**
     * The limit of the number of addresses found on a search.
     */
    protected $limit = 0;

    /**
     * The current page number when searching addresses.
     */
    protected $page = 0;

    /**
     * $address_response is the array response from the API call.
     */
    public function __construct(Transport $transport, $address_response = null)
    {
        $this->transport = $transport;
        $this->raw_response = $address_response;
    }

    /**
     * Return the URI used to search for addresses.
     */
    public function getSearchUri($params)
    {
        return $this->transport->getUri([$this->path], $params);
    }

    /**
     * Return the URI used to ferch an addresses by UDPRN.
     */
    public function getUdprnUri($udprn)
    {
        return $this->transport->getUri([$this->path, $udprn]);
    }

    /**
     * Get all addresses for a query from the API.
     */
    public function search($query, $limit = null, $page = null)
    {
        $params = ['query' => $query];

        if (isset($limit)) {
            $params['limit'] = $limit;
        }

        if (isset($page)) {
            $params['page'] = $page;
        }

        $url = $this->getSearchUri($params);

        $response = $this->transport->get($url);

        $addresses = $this->parseResponse($response);

        $address_collection = new Sequence;

        if (isset($addresses['total'])) {
            $this->total = $addresses['total'];
        }

        if (isset($addresses['limit'])) {
            $this->limit = $addresses['limit'];
        }

        if (isset($addresses['page'])) {
            $this->page = $addresses['page'];
        }

        if (!empty($addresses['hits'])) {
            foreach($addresses['hits'] as $address) {
                $address_collection->add(new Address($this->transport, $address));
            }
        }

        // Return a collection of addresses.
        return $address_collection;
    }

    /**
     * Get a signle addresses by UDPRN.
     */
    public function get($udprn)
    {
        $url = $this->getUdprnUri($udprn);

        $response = $this->transport->get($url);

        $address = $this->parseResponse($response);

        if (!empty($address)) {
            $result = new Address($this->transport, $address);
        } else {
            $result = null;
        }

        // Return a collection of addresses.
        return $result;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function getPage()
    {
        return $this->page;
    }
}

