<?php

namespace Imbue\SendCloud\Resources;

class ShippingMethod extends AbstractResource
{
    /** @var string */
    public $id;
    /** @var string */
    public $name;
    /** @var string */
    public $carrier;
    /** @var string */
    public $max_weight;
    /** @var string */
    public $service_point_input;
    /** @var string */
    public $min_weight;
    /** @var float */
    public $price;
    /** @var array */
    public $countries;
}
