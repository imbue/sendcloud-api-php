<?php

namespace Imbue\SendCloud\Endpoints;

use Imbue\SendCloud\Exceptions\ApiException;
use Imbue\SendCloud\Resources\Collections\ParcelCollection;
use Imbue\SendCloud\Resources\GenericStatus;
use Imbue\SendCloud\Resources\Parcel;
use Imbue\SendCloud\Resources\ParcelMulti;
use Imbue\SendCloud\Resources\ResourceFactory;

class ParcelMultiEndpoint extends AbstractEndpoint
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
     * @param array $data
     * @return ParcelCollection
     * @throws ApiException
     */
    public function create(array $data = []): ParcelCollection
    {
        return $this->restCreateCollection($data);
    }
}
