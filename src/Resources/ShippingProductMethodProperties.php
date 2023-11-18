<?php

namespace Imbue\SendCloud\Resources;

class ShippingProductMethodProperties
{
    /** @var int */
    public $min_weight;

    /** @var int */
    public $max_weight;

    /** @var ShippingProductMethodPropertiesMaxDimensions */
    public $max_dimensions;
}

