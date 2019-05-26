<?php

namespace Imbue\SendCloud\Resources\Collections;

use Imbue\SendCloud\Resources\ParcelStatus;

class ParcelStatusCollection extends AbstractCollection
{
    /**
     * @return string|null
     */
    public function getCollectionResourceName()
    {
        return null;
    }

    /**
     * @return ParcelStatus
     */
    protected function createResourceObject(): ParcelStatus
    {
        return new ParcelStatus($this->client);
    }
}
