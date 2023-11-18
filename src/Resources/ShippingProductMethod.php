<?php

namespace Imbue\SendCloud\Resources;

class ShippingProductMethod
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var AvailableShippingFunctionality */
    public $functionalities;

    /** @var string */
    public $shippingProductCode;

    /** @var ShippingProductMethodProperties */
    public $properties;

    /** @var object */
    public $leadTimeHours;
}
