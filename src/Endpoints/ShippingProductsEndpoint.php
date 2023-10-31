<?php

namespace Imbue\SendCloud\Endpoints;

use Imbue\SendCloud\Exceptions\ApiException;
use Imbue\SendCloud\Resources\AbstractResource;
use Imbue\SendCloud\Resources\Collections\AbstractCollection;
use Imbue\SendCloud\Resources\Collections\ShippingProductCollection;
use Imbue\SendCloud\Resources\ShippingProduct;

class ShippingProductsEndpoint extends AbstractEndpoint
{
    /** @var string */
    protected $resourcePath = 'shipping_products';
    /** @var string */
    protected $singleResourceKey = 'shipping_product';

    /**
     * @return mixed
     */
    protected function getResourceObject(): ShippingProduct
    {
        return new ShippingProduct($this->client);
    }

    /**
     * @return ShippingProductCollection
     */
    protected function getResourceCollectionObject(): ShippingProductCollection
    {
        return new ShippingProductCollection(null, null);
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
