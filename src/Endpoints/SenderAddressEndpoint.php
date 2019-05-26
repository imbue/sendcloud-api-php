<?php

namespace Imbue\SendCloud\Endpoints;

use Imbue\SendCloud\Exceptions\ApiException;
use Imbue\SendCloud\Resources\AbstractResource;
use Imbue\SendCloud\Resources\Collections\AbstractCollection;
use Imbue\SendCloud\Resources\Collections\SenderAddressCollection;
use Imbue\SendCloud\Resources\SenderAddress;

class SenderAddressEndpoint extends AbstractEndpoint
{
    /** @var string */
    protected $resourcePath = 'user/addresses/sender';

    /** @var string */
    protected $singleResourceKey = 'sender_address';

    /**
     * @return SenderAddress
     */
    protected function getResourceObject(): SenderAddress
    {
        return new SenderAddress($this->client);
    }

    /**
     * @return SenderAddressCollection
     */
    protected function getResourceCollectionObject(): SenderAddressCollection
    {
        return new SenderAddressCollection($this->client);
    }

    /**
     * @param $id
     * @return AbstractResource
     * @throws ApiException
     */
    public function get($id)
    {
        return $this->restRead($id, []);
    }

    /**
     * @return array|AbstractCollection
     * @throws ApiException
     */
    public function list()
    {
        return $this->restList([]);
    }
}
