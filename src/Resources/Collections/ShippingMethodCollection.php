<?php

namespace Imbue\SendCloud\Resources\Collections;

use Imbue\SendCloud\Resources\ShippingMethod;

class ShippingMethodCollection extends AbstractCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return 'shipping_methods';
    }

    /**
     * @return ShippingMethod
     */
    protected function createResourceObject(): ShippingMethod
    {
        return new ShippingMethod($this->client);
    }
}
