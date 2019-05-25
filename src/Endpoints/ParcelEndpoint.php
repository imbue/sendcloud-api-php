<?php

namespace Imbue\SendCloud\Endpoints;

use Imbue\SendCloud\Exceptions\ApiException;
use Imbue\SendCloud\Resources\Collections\AbstractCollection;
use Imbue\SendCloud\Resources\Collections\ParcelCollection;
use Imbue\SendCloud\Resources\Parcel;

class ParcelEndpoint extends AbstractEndpoint
{
    /** @var string */
    protected $resourcePath = 'parcels';

    /**
     * @return Parcel
     */
    protected function getResourceObject(): Parcel
    {
        return new Parcel($this->client);
    }

    /**
     * @param $previous
     * @param $next
     * @return ParcelCollection
     */
    protected function getResourceCollectionObject($previous, $next): ParcelCollection
    {
        return new ParcelCollection($this->client, $previous, $next);
    }

    /**
     * @return array|AbstractCollection
     * @throws ApiException
     */
    public function list()
    {
        return $this->restList();
    }
}
