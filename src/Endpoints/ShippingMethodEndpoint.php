<?php

namespace Imbue\SendCloud\Endpoints;

use Imbue\SendCloud\Exceptions\ApiException;
use Imbue\SendCloud\Resources\AbstractResource;
use Imbue\SendCloud\Resources\Collections\AbstractCollection;
use Imbue\SendCloud\Resources\Collections\ShippingMethodCollection;
use Imbue\SendCloud\Resources\ShippingMethod;

class ShippingMethodEndpoint extends AbstractEndpoint
{
    /** @var string */
    protected $resourcePath = 'shipping_methods';
    /** @var string */
    protected $singleResourceKey = 'shipping_method';

    /**
     * @return mixed
     */
    protected function getResourceObject(): ShippingMethod
    {
        return new ShippingMethod($this->client);
    }

    /**
     * @return ShippingMethodCollection
     */
    protected function getResourceCollectionObject(): ShippingMethodCollection
    {
        return new ShippingMethodCollection(null, null);
    }

    /**
     * @param       $id
     * @param array $filters
     * @return AbstractResource
     * @throws ApiException
     */
    public function get($id, array $filters = [])
    {
        return $this->restRead($id, $filters);
    }

    /**
     * @param $filters
     * @return array|AbstractCollection
     * @throws ApiException
     */
    public function list(array $filters = [])
    {
        return $this->restList($filters);
    }
}
