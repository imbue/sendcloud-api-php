<?php

namespace Imbue\SendCloud\Resources;

class Invoice extends AbstractResource
{
    /** @var string */
    public $type;
    /** @var string */
    public $ref;
    /** @var bool */
    public $isPayed;
    /** @var array */
    public $items;
}
