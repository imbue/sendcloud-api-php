<?php

namespace Imbue\SendCloud\Endpoints;

use Imbue\SendCloud\Exceptions\ApiException;
use Imbue\SendCloud\Resources\Collections\AbstractCollection;
use Imbue\SendCloud\Resources\Collections\IntegrationShipmentCollection;
use Imbue\SendCloud\Resources\IntegrationShipment;

class IntegrationShipmentEndpoint extends AbstractEndpoint
{
    /** @var string */
    protected $resourcePath = 'integrations/{}/shipments';

    /**
     * @return IntegrationShipment
     */
    protected function getResourceObject(): IntegrationShipment
    {
        return new IntegrationShipment($this->client);
    }

    /**
     * @param $previous
     * @param $next
     * @return IntegrationShipmentCollection
     */
    protected function getResourceCollectionObject($previous, $next): IntegrationShipmentCollection
    {
        return new IntegrationShipmentCollection($this->client, $previous, $next);
    }

    /**
     * @param int   $integrationId
     * @param array $filters
     * @return array|AbstractCollection
     * @throws ApiException
     */
    public function list(int $integrationId, $filters = [])
    {
        $this->parentId = $integrationId;
        return $this->restList($filters);
    }

    /**
     * @param int   $integrationId
     * @param array $data
     * @return mixed
     * @throws ApiException
     */
    public function upsert(int $integrationId, array $data = [])
    {
        $this->parentId = $integrationId;
        return $this->restCreate($data);
    }
}
