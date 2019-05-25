<?php

namespace Imbue\SendCloud\Resources\Collections;

use ArrayObject;

abstract class AbstractCollection extends ArrayObject
{
    /** @var string */
    public $previous;
    /** @var string */
    public $next;

    /**
     * AbstractCollection constructor.
     * @param $previous
     * @param $next
     */
    public function __construct($previous = null, $next = null)
    {
        parent::__construct();
        $this->previous = $previous;
        $this->next = $next;
    }

    /**
     * @return string|null
     */
    abstract public function getCollectionResourceName();
}
