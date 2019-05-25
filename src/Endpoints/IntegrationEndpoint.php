<?php

namespace Imbue\SendCloud\Endpoints;

use Imbue\SendCloud\Exceptions\ApiException;
use Imbue\SendCloud\Resources\Collections\AbstractCollection;
use Imbue\SendCloud\Resources\Integration;

class IntegrationEndpoint extends AbstractEndpoint
{
    /** @var string */
    protected $resourcePath = 'integrations';

    /**
     * @return Integration
     */
    protected function getResourceObject(): Integration
    {
        return new Integration($this->client);
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
