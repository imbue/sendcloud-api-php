<?php

namespace Imbue\SendCloud\Resources\Collections;

use Imbue\SendCloud\Resources\Parcel;

class ParcelCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return 'parcels';
    }

    /**
     * @return Parcel
     */
    protected function createResourceObject(): Parcel
    {
        return new Parcel($this->client);
    }
}
