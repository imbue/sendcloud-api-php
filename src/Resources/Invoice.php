<?php

namespace Imbue\SendCloud\Resources;

class Invoice extends AbstractResource
{
    /** @var int */
    public $id;
    /** @var string */
    public $type;
    /** @var string */
    public $ref;
    /** @var bool */
    public $isPayed;
    /** @var array */
    public $items;
    /** @var float */
    public $price_incl;
    /** @var float */
    public $price_excl;
    /** @var string */
    public $date;
}
