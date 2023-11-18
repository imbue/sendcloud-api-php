<?php

namespace Imbue\SendCloud\Resources\Collections;

use Imbue\SendCloud\Resources\ShippingProduct;

class ShippingProductCollection extends AbstractCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return 'shipping_products';
    }

    /**
     * @return ShippingProduct
     */
    protected function createResourceObject(): ShippingProduct
    {
        return new ShippingProduct($this->client);
    }
}
