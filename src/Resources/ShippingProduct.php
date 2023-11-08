<?php

namespace Imbue\SendCloud\Resources;

class ShippingProduct extends AbstractResource
{
    /** @var string */
    public $name;

    /** @var string */
    public $code;

    /** @var string */
    public $carrier;

    /** @var string */
    public $service_points_carrier;

    /** @var WeightRange */
    public $weight_range;

    /** @var AvailableShippingFunctionality[] */
    public $available_functionalities;

    /** @var ShippingProductMethod[] */
    public $methods;
}