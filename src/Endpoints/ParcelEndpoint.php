<?php

namespace Imbue\SendCloud\Endpoints;

use Imbue\SendCloud\Exceptions\ApiException;
use Imbue\SendCloud\Resources\Collections\ParcelCollection;
use Imbue\SendCloud\Resources\GenericStatus;
use Imbue\SendCloud\Resources\Parcel;
use Imbue\SendCloud\Resources\ResourceFactory;

class ParcelEndpoint extends AbstractEndpoint
{
    /** @var string */
    protected $resourcePath = 'parcels';
    /** @var string */
    protected $singleResourceKey = 'parcel';

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
     * @param $id
     * @return Parcel
     * @throws ApiException
     */
    public function get($id)
    {
        return $this->restRead($id, []);
    }

    /**
     * @param array $filters
     * @return ParcelCollection
     * @throws ApiException
     */
    public function list(array $filters = [])
    {
        return $this->restList($filters);
    }

    /**
     * @param array $data
     * @return Parcel
     * @throws ApiException
     */
    public function create(array $data = [])
    {
        return $this->restCreate($data);
    }

    /**
     * @param array $data
     * @return GenericStatus
     * @throws ApiException
     */
    public function cancel(string $id)
    {
        $result = $this->client->performHttpCall(
            self::REST_CREATE,
            "{$this->getResourcePath()}/{$id}/cancel",
            $this->parseRequestBody([])
        );

        return ResourceFactory::createFromApiResult($result, new GenericStatus($this->client));
    }
}
